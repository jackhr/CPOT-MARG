<?php


function generateRandomKey($length = 24)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $key;
}
function validateEmails($email_str)
{
    // Split the string by commas
    $emails = array_map('trim', explode(',', $email_str));

    // Validate each email
    foreach ($emails as $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // Return false if any email is invalid
        }
    }
    return true; // Return true if all emails are valid
}

function handleSendEmail($from, $email_str = "", $email_body = "", $subject = "", $reply_to = "")
{
    // Validate 'from' email
    if (isset($from) && gettype($from) === "string") {
        $from .= "@margriehunt.com";
    } else {
        throw new Error("Invalid 'from' email address domain provided");
    }

    // Validate 'from' email
    if (!validateEmails($from)) {
        throw new Error("Invalid 'from' email address");
    }

    // Validate recipient email
    $emails = array_map('trim', explode(',', $email_str));
    foreach ($emails as $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Error("Invalid recipient email address: $email");
        }
    }

    // Validate 'reply-to' email if provided
    if ($reply_to && !filter_var($reply_to, FILTER_VALIDATE_EMAIL)) {
        throw new Error("Invalid 'reply-to' email address");
    }

    // Prepare headers
    $headers  = "From: {$from}\r\n";
    if (strlen($reply_to) > 0) {
        $headers .= "Reply-To: $reply_to\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Send email to recipients
    if (!mail($email_str, $subject, $email_body, $headers)) {
        error_log("Failed to send email to $email_str");
    }

    return true; // Return true if all emails are processed
}

function renderAddOnsInEmail($add_ons, $order_item)
{
    $str = '
        <table width="100%"
            style="border-collapse: collapse; background-color: #ffffff; border-bottom: 1px solid #dcdcdc;">
            <tr>
                <td style="padding: 12px;">
                    <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">Add-Ons</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">
                    <table width="100%" style="border-collapse: collapse;">';

    foreach ($add_ons as $add_on) {
        $add_on_is_applied = false;

        if (!empty($order_item['add_ons'])) {
            foreach ($order_item['add_ons'] as $item_add_on) {
                if ($item_add_on['add_on_id'] === $add_on['add_on_id']) {
                    $add_on_is_applied = true;
                    break;
                }
            }
        }

        $final_add_on_str = ($add_on_is_applied ? "With" : "Without") . " {$add_on['name']}";
        $final_price = $add_on_is_applied ? $add_on['price'] : "0";

        $str .= '
            <tr>
                <td style="padding: 5px 0; font-size: 14px; font-weight: bold; text-align: left;">
                    ' . $final_add_on_str . ':
                </td>
                <td style="padding: 5px 0; font-size: 14px; font-weight: bold; text-align: right;">
                    $' . $final_price . ' (USD)
                </td>
            </tr>
        ';
    }

    $str .= '
                    </table>
                </td>
            </tr>
        </table>
    ';

    return $str;
}

function generateSconceOrderEmail($pdo, $order_id, $is_admin = false)
{
    $add_ons_stmt = $pdo->prepare("SELECT * FROM `add_ons`;");
    $add_ons_stmt->execute();
    $add_ons = $add_ons_stmt->fetchAll(PDO::FETCH_ASSOC);

    $order_stmt = $pdo->prepare("SELECT
        o.*,
        c.first_name,
        c.last_name,
        c.email,
        c.phone
    FROM
        orders o
    LEFT JOIN
        contact_info c ON o.contact_id = c.contact_id
    WHERE
        o.order_id = :order_id;
    ");
    $order_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $order_stmt->execute();
    $order = $order_stmt->fetch(PDO::FETCH_ASSOC);

    $order_items_stmt = $pdo->prepare("SELECT
        oi.*,
        s.name AS sconce_name,
        s.base_price AS sconce_base_price,
        s.dimensions AS sconce_dimensions,
        s.material AS sconce_material,
        s.color AS sconce_color,
        si.image_url AS sconce_image_url,
        c.name AS cutout_name,
        c.base_price AS cutout_base_price,
        c.description AS cutout_description,
        ci.image_url AS cutout_image_url
    FROM
        order_items oi
    LEFT JOIN
        sconces s ON oi.sconce_id = s.sconce_id
    LEFT JOIN 
        cutouts c ON oi.cutout_id = c.cutout_id
    LEFT JOIN
        sconce_images si ON s.primary_image_id = si.image_id
    LEFT JOIN 
        cutout_images ci ON c.primary_image_id = ci.image_id
    WHERE
        oi.order_id = :order_id;
    ");
    $order_items_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $order_items_stmt->execute();
    $order_items = $order_items_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($order_items as $idx => $item) {
        $add_ons_stmt = $pdo->prepare("SELECT * FROM `order_item_add_ons` WHERE order_item_id = :order_item_id;");
        $add_ons_stmt->bindParam(':order_item_id', $item['order_item_id'], PDO::PARAM_INT);
        $add_ons_stmt->execute();
        $order_item_add_ons = $add_ons_stmt->fetchAll(PDO::FETCH_ASSOC);
        $order_items[$idx]['add_ons'] = $order_item_add_ons;
    }

    $order_info_html = '<div id="cart-list" style="box-sizing: border-box; width: 100%; max-width: 800px;">';
    foreach ($order_items as $item) {
        $item['sconce_image_url'] = isset($item['sconce_image_url']) ? "https://www.marg.tropicalstudios.com{$item['sconce_image_url']}" : "";
        $item['cutout_image_url'] = isset($item['cutout_image_url']) ? "https://www.marg.tropicalstudios.com{$item['cutout_image_url']}" : "";

        $order_info_html .= '
            <!-- Product Listing -->
            <table width="100%"
                style="border-collapse: collapse; background-color: #ffffff; border-top: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">
                <tr>
                    <td style="padding: 12px;">
                        <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">Sconce "' . $item['sconce_name'] . '"</h3>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px;">
                        <table width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="width: 150px; text-align: center; vertical-align: top;">
                                    ' . (isset($item['sconce_image_url']) ? '
                                        <img src="https://www.marg.tropicalstudios.com' . str_replace(" ", "%20", $item['sconce_image_url']) . '"
                                            alt="' . $item['sconce_name'] . ' Sconce" width="150" style="display: block; border: 1px solid #ddd;">
                                    ' : '
                                        <div style="display: block; border: 1px solid #ddd;width:150px;height:150px;"></div>
                                    ') . '
                                </td>
                                <td style="padding-left: 12px; vertical-align: top;">
                                    <p style="margin: 5px 0;">Price: <strong>$' . $item['sconce_base_price'] . ' (USD)</strong></p>
                                    <p style="margin: 5px 0;">Size: <strong>' . $item['sconce_dimensions'] . '</strong></p>
                                    <p style="margin: 5px 0;">Material: <strong>' . $item['sconce_material'] . '</strong></p>
                                    <p style="margin: 5px 0;">Color: <strong>' . $item['sconce_color'] . '</strong></p>
                                    <p style="margin: 5px 0;">Mounting Type: <strong>Wall Mounted</strong></p>
                                    <p style="margin: 5px 0;">Description: <strong>-</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Cutout Section -->
            <table width="100%"
                style="border-collapse: collapse; background-color: #ffffff; border-bottom: 1px solid #dcdcdc;">
                <tr>
                    <td style="padding: 12px;">
                        <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">' . (isset($item['cutout_name']) ? "Cutout \"{$item['cutout_name']}\"" : "No Cutout") . '</h3>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px;">
                        <table width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="width: 150px; text-align: center; vertical-align: top;">
                                    ' . (isset($item['cutout_image_url']) ? '
                                        <img src="https://www.marg.tropicalstudios.com' . str_replace(" ", "%20", $item['cutout_image_url']) . '"
                                            alt="' . $item['cutout_name'] . ' Cutout" width="150" style="display: block; border: 1px solid #ddd;">
                                    ' : '
                                        <div style="display: block; border: 1px solid #ddd;width:150px;height:150px;"></div>
                                    ') . '
                                </td>
                                <td style="padding-left: 12px; vertical-align: top;">
                                    <p style="margin: 5px 0;">Price: <strong>$' . ($item['cutout_base_price'] ?? "0") . ' (USD)</strong></p>
                                    <p style="margin: 5px 0;">Description: <strong>' . ($item['cutout_description'] ?? "-") . '</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Add-Ons Section -->
            ' . renderAddOnsInEmail($add_ons, $item) . '

            <!-- Sub total section -->
            <table width="100%"
                style="border-collapse: collapse; border-bottom: 1px solid #dcdcdc; font-size: 16px; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 12px; text-align: left; font-weight: bold;">
                        ' . $item['description'] . '
                    </td>
                    <td style="padding: 12px; text-align: right; font-weight: bold;">
                        $' . $item['price'] . '
                    </td>
                </tr>
            </table>
        ';
    }

    $order_info_html .= '
        <!-- Order Summary -->
        <table width="100%"
            style="border-collapse: collapse; background-color: #ffffff; border-top: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">
            <tr>
                <td style="padding: 12px; text-align: center; font-weight: bold; font-size: 18px;">
                    Order Summary
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: left;">Subtotal:</td>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: right;">$' . $order['total_amount'] . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: left;">Delivery Fee:</td>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: right;">FREE</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-top: 1px solid #ddd; padding-top: 12px; font-weight: bold;font-size:16px;">Total: $' . $order['total_amount'] . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    ';
    $order_info_html .= "</div>";

    $html_data = [
        "first_name" => $order['first_name'],
        "last_name" => $order['last_name'],
        "email" => $order['email'],
        "phone" => $order['phone'],
        "message" => $order['message'],
        "year" => date("Y"),
        "order_info_html" => $order_info_html
    ];

    if ($is_admin) {
        $template_path = __DIR__ . "/emails/orders/admin.html";
    } else {
        $template_path = __DIR__ . "/emails/orders/client.html";
    }

    if (!file_exists($template_path)) {
        throw new Error("Email template file not found: $template_path");
    }

    $email_body = file_get_contents($template_path);

    // Replace placeholders with actual data
    foreach ($html_data as $key => $value) {
        if ($key === "order_info_html") {
            $email_body = str_replace("{{{$key}}}", $value, $email_body);
        } else {
            $email_body = str_replace("{{{$key}}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $email_body);
        }
    }

    return $email_body;
}

function generateShopItemEnquiryEmail($pdo, $enquiry_id, $is_admin = false)
{
    $enquiry_stmt = $pdo->prepare("SELECT
        e.*,
        si.*,
        si_image.image_url AS shop_item_image_url,
        c.first_name,
        c.last_name,
        c.email,
        c.address_1,
        c.country,
        c.state,
        c.town_or_city,
        c.phone
    FROM
        shop_item_enquiries e
    LEFT JOIN
        contact_info c ON e.contact_id = c.contact_id
    LEFT JOIN
        shop_items si ON e.shop_item_id = si.shop_item_id
    LEFT JOIN
        shop_item_images si_image ON si.primary_image_id = si_image.image_id
    WHERE
        e.enquiry_id = :enquiry_id;
    ");

    $enquiry_stmt->bindParam(':enquiry_id', $enquiry_id, PDO::PARAM_INT);
    $enquiry_stmt->execute();
    $enquiry = $enquiry_stmt->fetch(PDO::FETCH_ASSOC);

    $enquiry_info_html = '
        <table width="100%"
            style="border-collapse: collapse; background-color: #ffffff; border-top: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">
            <tr>
                <td style="padding: 12px;">
                    <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">Shop Item "' . $enquiry['name'] . '"</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="width: 150px; text-align: center; vertical-align: top;">
                                ' . (isset($enquiry['shop_item_image_url']) ? '
                                    <img src="https://www.marg.tropicalstudios.com' . str_replace(" ", "%20", $enquiry['shop_item_image_url']) . '"
                                        alt="' . $enquiry['name'] . ' Sconce" width="150" style="display: block; border: 1px solid #ddd;">
                                ' : '
                                    <div style="display: block; border: 1px solid #ddd;width:150px;height:150px;"></div>
                                ') . '
                            </td>
                            <td style="padding-left: 12px; vertical-align: top;">
                                <p style="margin: 5px 0;">Price: <strong>$' . $enquiry['price'] . ' (USD)</strong></p>
                                <p style="margin: 5px 0;">Size: <strong>' . $enquiry['dimensions'] . '</strong></p>
                                <p style="margin: 5px 0;">Material: <strong>' . $enquiry['material'] . '</strong></p>
                                <p style="margin: 5px 0;">Color: <strong>' . $enquiry['color'] . '</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Sub total section -->
        <table width="100%"
            style="border-collapse: collapse; border-bottom: 1px solid #dcdcdc; font-size: 16px; margin-bottom: 20px;">
            <tr>
                <td style="padding: 12px; text-align: left; font-weight: bold;">
                    ' . $enquiry['description'] . '
                </td>
                <td style="padding: 12px; text-align: right; font-weight: bold;">
                    $' . $enquiry['price'] . '
                </td>
            </tr>
        </table>

        <!-- Order Summary -->
        <table width="100%"
            style="border-collapse: collapse; background-color: #ffffff; border-top: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">
            <tr>
                <td style="padding: 12px; text-align: center; font-weight: bold; font-size: 18px;">
                    Order Summary
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: left;">Subtotal:</td>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: right;">$' . $enquiry['price'] . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: left;">Delivery Fee:</td>
                            <td style="padding: 5px 0; font-size: 14px; font-weight: bold;text-align: right;">FREE</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-top: 1px solid #ddd; padding-top: 12px; font-weight: bold;font-size:16px;">Total: $' . $enquiry['price'] . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    ';

    $html_data = [
        "first_name" => $enquiry['first_name'],
        "last_name" => $enquiry['last_name'],
        "email" => $enquiry['email'],
        "phone" => $enquiry['phone'],
        "address_1" => $enquiry['address_1'],
        "country" => $enquiry['country'],
        "state" => $enquiry['state'],
        "town_or_city" => $enquiry['town_or_city'],
        "message" => $enquiry['message'],
        "year" => date("Y"),
        "enquiry_info_html" => $enquiry_info_html
    ];


    if ($is_admin) {
        $template_path = __DIR__ . "/emails/enquiries/shop/admin.html";
    } else {
        $template_path = __DIR__ . "/emails/enquiries/shop/client.html";
    }

    if (!file_exists($template_path)) {
        throw new Error("Email template file not found: $template_path");
    }

    $email_body = file_get_contents($template_path);

    // Replace placeholders with actual data
    foreach ($html_data as $key => $value) {
        if ($key === "enquiry_info_html") {
            $email_body = str_replace("{{{$key}}}", $value, $email_body);
        } else {
            $email_body = str_replace("{{{$key}}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $email_body);
        }
    }

    return $email_body;
}

function generatePortfolioItemEnquiryEmail($pdo, $enquiry_id, $is_admin = false)
{
    $enquiry_stmt = $pdo->prepare("SELECT
        e.*,
        pi.*,
        pi_image.image_url AS portfolio_item_image_url,
        c.first_name,
        c.last_name,
        c.email,
        c.address_1,
        c.country,
        c.state,
        c.town_or_city,
        c.phone
    FROM
        portfolio_item_enquiries e
    LEFT JOIN
        contact_info c ON e.contact_id = c.contact_id
    LEFT JOIN
        portfolio_items pi ON e.portfolio_item_id = pi.portfolio_item_id
    LEFT JOIN
        portfolio_item_images pi_image ON pi.primary_image_id = pi_image.image_id
    WHERE
        e.enquiry_id = :enquiry_id;
    ");

    $enquiry_stmt->bindParam(':enquiry_id', $enquiry_id, PDO::PARAM_INT);
    $enquiry_stmt->execute();
    $enquiry = $enquiry_stmt->fetch(PDO::FETCH_ASSOC);

    $enquiry_info_html = '
        <table width="100%"
            style="border-collapse: collapse; background-color: #ffffff; border-top: 1px solid #dcdcdc; border-bottom: 1px solid #dcdcdc;">
            <tr>
                <td style="padding: 12px;">
                    <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">Portfolio Item "' . $enquiry['name'] . '"</h3>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="width: 150px; text-align: center; vertical-align: top;">
                                ' . (isset($enquiry['portfolio_item_image_url']) ? '
                                    <img src="https://www.marg.tropicalstudios.com' . str_replace(" ", "%20", $enquiry['portfolio_item_image_url']) . '"
                                        alt="' . $enquiry['name'] . ' Sconce" width="150" style="display: block; border: 1px solid #ddd;">
                                ' : '
                                    <div style="display: block; border: 1px solid #ddd;width:150px;height:150px;"></div>
                                ') . '
                            </td>
                            <td style="padding-left: 12px; vertical-align: top;">
                                <p style="margin: 5px 0;">Size: <strong>' . $enquiry['dimensions'] . '</strong></p>
                                <p style="margin: 5px 0;">Material: <strong>' . $enquiry['material'] . '</strong></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    ';

    $html_data = [
        "first_name" => $enquiry['first_name'],
        "last_name" => $enquiry['last_name'],
        "email" => $enquiry['email'],
        "phone" => $enquiry['phone'],
        "address_1" => $enquiry['address_1'],
        "country" => $enquiry['country'],
        "state" => $enquiry['state'],
        "town_or_city" => $enquiry['town_or_city'],
        "message" => $enquiry['message'],
        "year" => date("Y"),
        "enquiry_info_html" => $enquiry_info_html
    ];


    if ($is_admin) {
        $template_path = __DIR__ . "/emails/enquiries/portfolio/admin.html";
    } else {
        $template_path = __DIR__ . "/emails/enquiries/portfolio/client.html";
    }

    if (!file_exists($template_path)) {
        throw new Error("Email template file not found: $template_path");
    }

    $email_body = file_get_contents($template_path);

    // Replace placeholders with actual data
    foreach ($html_data as $key => $value) {
        if ($key === "enquiry_info_html") {
            $email_body = str_replace("{{{$key}}}", $value, $email_body);
        } else {
            $email_body = str_replace("{{{$key}}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $email_body);
        }
    }

    return $email_body;
}
