<?php

namespace Database\Seeders;

use App\Models\NotifyTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotifyTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'type' => 'WELCOME',
                'name' => 'User Welcome Email',
                'title' => 'Welcome to {site_name}!',
                'message' => 'Welcome, {user_name}! We\'re thrilled to have you. Explore our digital products and find what you need.',
                'subject' => 'Welcome to {site_name} – Your Account is Ready!',
                'content' => '
                    <p>Hi {user_name},</p>
                    <p>Welcome to <strong>{site_name}</strong>! We are thrilled to have you join our community of creators and developers.</p>
                    <p>You can now log in and start exploring our collection of high-quality digital products. Whether you\'re looking for themes, plugins, or graphics, we\'ve got something for you.</p>
                    <p>To get started, why not <a href="{products_link}">browse our latest products</a>?</p>
                    <p>If you have any questions, our support team is always here to help.</p>
                    <p>Thank you for choosing {site_name}!</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'User full name.',
                    'products_link' => 'products page.',
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'EMAIL_VERIFICATION',
                'name' => 'Email Verification',
                'title' => 'Verify Your Email Address',
                'message' => 'Please verify your email to complete your registration for {site_name}.',
                'subject' => 'Verify Your Email Address for {site_name}',
                'content' => '
                    <p>Hi {user_name},</p>
                    <p>Thanks for registering at <strong>{site_name}</strong>. Please click the button below to verify your email address and activate your account.</p>
                    <br>
                    <p style="text-align:center;"><a href="{verification_link}" style="background-color:#0d6efd;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;">Verify Email Address</a></p>
                    <br>
                    <p>If you did not create an account, no further action is required.</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'User full name.',
                    'verification_link' => 'email verify Link.',
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'PASSWORD_RESET',
                'name' => 'Password Reset Request',
                'title' => 'Password Reset Request',
                'message' => 'A request to reset your {site_name} account password has been received.',
                'subject' => 'Reset Your Password for {site_name}',
                'content' => '
                    <p>Hello {user_name},</p>
                    <p>We received a request to reset your password. If you made this request, click the button below. This link is valid for 60 minutes.</p>
                    <br>
                    <p style="text-align:center;"><a href="{reset_link}" style="background-color:#0d6efd;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;">Reset Your Password</a></p>
                    <br>
                    <p>If you did not request a password reset, you can safely ignore this email.</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'User full name.',
                    'reset_link' => 'Password reset.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'PASSWORD_CHANGED',
                'name' => 'Password Change Confirmation',
                'title' => 'Your Password Has Been Changed',
                'message' => 'This is a confirmation that the password for your {site_name} account has been successfully changed.',
                'subject' => '[Security Alert] Your {site_name} Password Has Been Changed',
                'content' => '
                    <p>Hello {user_name},</p>
                    <p>This email confirms that the password for your account at <strong>{site_name}</strong> was changed at {change_time}.</p>
                    <p>If you were the one who made this change, you can safely disregard this email.</p>
                    <p>If you did NOT change your password, your account may have been compromised. Please <a href="{reset_link}">reset your password immediately</a> and contact our support team.</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'User full name.',
                    'change_time' => 'Time of the password change.',
                    'reset_link' => 'password reset link.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'ORDER_CONFIRMATION',
                'name' => 'Order Confirmation & Downloads',
                'title' => 'Your Order is Complete!',
                'message' => 'Thank you for your order! Your downloads are ready. Order: {order_code}',
                'subject' => 'Your {site_name} Order is Complete! ({order_code})',
                'content' => '
                    <p>Hi {user_name},</p>
                    <p>Thank you for your purchase from <strong>{site_name}</strong>! Your order has been processed successfully. You can download your purchased items from your account dashboard or using the links below.</p>
                    <h3>Order Summary ({order_code})</h3>
                    <p><strong>Total Amount:</strong> {order_total}</p>
                    <p><strong>Payment Method:</strong> {payment_method}</p>
                    <hr>
                    <h3>Your Products:</h3>
                    {order_items_table}
                    <br>
                    <p>You can also view all your past orders and downloads by visiting the <a href="{downloads_link}">Downloads section</a> of your account.</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'Customer name.',
                    'order_code' => 'Order ID.',
                    'order_total' => 'Total amount paid.',
                    'payment_method' => 'Payment method used.',
                    'order_items_table' => 'HTML table of products with download links.',
                    'downloads_link' => 'Link to user\'s download page.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'MANUAL_PAYMENT_APPROVED',
                'name' => 'Manual Payment Approved',
                'title' => 'Your Payment is Approved!',
                'message' => 'Your manual payment for order {order_code} has been approved and your downloads are ready.',
                'subject' => 'Payment Approved! Your {site_name} Order is Ready ({order_code})',
                'content' => '
                    <p>Hi {user_name},</p>
                    <p>Great news! We have successfully verified your manual payment for order <strong>{order_code}</strong>. Your order is now complete and your products are ready to be downloaded.</p>
                    <h3>Your Products:</h3>
                    {order_items_table}
                    <br>
                    <p>Thank you for your patience. You can view all your purchases in the <a href="{downloads_link}">Downloads section</a> of your account.</p>
                ',
                'shortcodes' => ([
                    'user_name' => 'Customer name.',
                    'order_code' => 'Order ID.',
                    'order_items_table' => 'HTML table of products with download links.',
                    'downloads_link' => 'Link to user\'s download page.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'PRODUCT_UPDATE',
                'name' => 'Product Update Notification',
                'title' => 'Product Update Available',
                'message' => 'A new version of {product_name} is now available for download!',
                'subject' => 'Update Available for {product_name} (v{product_version})',
                'content' => '
                    <p>Hello {user_name},</p>
                    <p>A new version of a product you purchased, <strong>{product_name}</strong>, has just been released!</p>
                    <p><strong>New Version:</strong> {product_version}</p>
                    <p>You can download the latest version from your account\'s download page. We recommend updating to benefit from the latest features and improvements.</p>
                    <br>
                    <p style="text-align:center;"><a href="{download_link}" style="background-color:#0d6efd;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;">Download Now</a></p>
                ',
                'shortcodes' => ([
                    'user_name' => 'User name.',
                    'product_name' => 'Name of the updated product.',
                    'product_version' => 'New version number.',
                    'download_link' => 'product download link.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'COMMENT_REPLY',
                'name' => 'New Reply to Your Comment',
                'title' => 'New Reply on {product_name}',
                'message' => '{replier_name} has replied to your comment on the product {product_name}.',
                'subject' => '{replier_name} replied to your comment on {product_name}',
                'content' => '
                    <p>Hi {user_name},</p>
                    <p><strong>{replier_name}</strong> has just replied to a comment you made on the product <strong>{product_name}</strong>.</p>
                    <p>Click the button below to view the reply and continue the conversation.</p>
                    <br>
                    <p style="text-align:center;"><a href="{comment_link}" style="background-color:#0d6efd;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;">View Reply</a></p>
                ',
                'shortcodes' => ([
                    'user_name' => 'Recipient\'s name.',
                    'replier_name' => 'replied username.',
                    'product_name' => 'Product name.',
                    'comment_link' => 'admin comment thread.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],

            // ===================================================================
            // ADMIN-FACING TEMPLATES
            // ===================================================================

            [
                'type' => 'ADMIN_NEW_ORDER',
                'name' => 'Admin: New Order Notification',
                'title' => 'New Sale!',
                'message' => 'New sale on {site_name}! Order {order_code} for {order_total}.',
                'subject' => '🎉 New Sale! Order {order_code} for {order_total}',
                'content' => '
                    <p>A new order has been placed on <strong>{site_name}</strong>.</p>
                    <ul>
                        <li><strong>Order ID:</strong> {order_code}</li>
                        <li><strong>Customer:</strong> {customer_name} ({customer_email})</li>
                        <li><strong>Amount:</strong> {order_total}</li>
                        <li><strong>Payment Method:</strong> {payment_method}</li>
                    </ul>
                    <p><a href="{order_link}">View the full order details in the admin panel.</a></p>
                ',
                'shortcodes' => ([
                    'order_code' => 'Order ID.',
                    'customer_name' => 'Customer name.',
                    'customer_email' => 'Customer email.',
                    'order_total' => 'Total sale amount.',
                    'payment_method' => 'Payment method used.',
                    'order_link' => 'admin order link.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'ADMIN_MANUAL_PAYMENT',
                'name' => 'Admin: Manual Payment Pending',
                'title' => 'Action Required: Verify Payment',
                'message' => 'A manual payment has been submitted for order {order_code} and requires verification.',
                'subject' => 'Action Required: Verify Manual Payment for Order {order_code}',
                'content' => '
                    <p>A customer has submitted a manual payment (bank transfer) that requires your verification.</p>
                    <ul>
                        <li><strong>Order ID:</strong> {order_code}</li>
                        <li><strong>Customer:</strong> {customer_name}</li>
                        <li><strong>Amount:</strong> {order_total}</li>
                    </ul>
                    <p>Please log in to the admin panel to review the submitted receipt and approve the order.</p>
                    <br>
                    <p style="text-align:center;"><a href="{order_link}" style="background-color:#ffc107;color:black;padding:12px 25px;text-decoration:none;border-radius:5px;">Verify Payment Now</a></p>
                ',
                'shortcodes' => ([
                    'order_code' => 'Order ID.',
                    'customer_name' => 'Customer name.',
                    'order_total' => 'order total.',
                    'order_link' => 'admin order link.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'ADMIN_CONTACT_FORM',
                'name' => 'Admin: New Contact Message',
                'title' => 'New Contact Message',
                'message' => 'New message received from {sender_name} via the contact form.',
                'subject' => 'New Contact Form Message from {sender_name}',
                'content' => '
                    <p>You have received a new message from the contact form on <strong>{site_name}</strong>.</p>
                    <hr>
                    <p><strong>Name:</strong> {sender_name}</p>
                    <p><strong>Email:</strong> <a href="mailto:{sender_email}">{sender_email}</a></p>
                    <p><strong>Subject:</strong> {message_subject}</p>
                    <hr>
                    <p><strong>Message:</strong></p>
                    <div style="padding:15px;border:1px solid #ddd;border-radius:5px;background-color:#f9f9f9;">
                        <p>{message_content}</p>
                    </div>
                ',
                'shortcodes' => ([
                    'sender_name' => 'Sender\'s name.',
                    'sender_email' => 'Sender\'s email.',
                    'message_subject' => 'Message subject.',
                    'message_content' => 'Contact message.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
            [
                'type' => 'ADMIN_NEW_REVIEW',
                'name' => 'Admin: New Review/Comment',
                'title' => 'New Content for Moderation',
                'message' => 'A new review/comment has been submitted on {product_name} and is awaiting moderation.',
                'subject' => 'New Review on "{product_name}" Awaiting Moderation',
                'content' => '
                    <p>A new review/comment has been submitted and is waiting for your approval.</p>
                    <ul>
                        <li><strong>Author:</strong> {author_name}</li>
                        <li><strong>Product:</strong> {product_name}</li>
                        <li><strong>Rating:</strong> {rating_stars}</li>
                    </ul>
                    <p><strong>Review Content:</strong></p>
                    <div style="padding:15px;border:1px solid #ddd;border-radius:5px;background-color:#f9f9f9;">
                        <p>{review_content}</p>
                    </div>
                    <br>
                    <p><a href="{moderation_link}">Click here to approve or reject this content.</a></p>
                ',
                'shortcodes' => ([
                    'author_name' => 'Author\'s name.',
                    'product_name' => 'Product name.',
                    'rating_stars' => 'Rating.',
                    'review_content' => 'comment.review text',
                    'moderation_link' => 'review link.'
                ]),
                'email_status' => true,
                'push_status' => false,
                'inapp_status' => false,
                'channels' => ['email'],
            ],
        ];


        foreach ($templates as $templateData) {
            NotifyTemplate::updateOrCreate(
                ['type' => $templateData['type']],
                $templateData
            );
        }
    }
}
