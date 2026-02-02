<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>
<style type="text/css">
    .btn-container {
            text-align: center;
            margin-top: 20px;
        }
</style>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="background-color: #4caf50; color: #ffffff; text-align: center; padding: 20px; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 24px;"> 🎉 Notification Email 🎉 </h1>
        </div>
        <!-- Body -->
        <div style="padding: 20px; color: #333333;">
             <p style="font-size: 16px;">
               Hello Dear,
            </p>
             
            <p style="font-size: 16px;">
               {{ $data['subject'] }}
            </p>

             <p style="font-size: 16px;">
               {{ $data['message'] }}
            </p>
              
            <p style="font-size: 14px; color: #666666;">
                Thank you,<br>
                The Admin Team
            </p>
        </div>
        <!-- Footer -->
        <div style="text-align: center; background: #f4f4f4; padding: 10px; font-size: 12px; color: #999999; border-radius: 0 0 8px 8px;">
            &copy; {{ date('Y') }} AetherSmart. All rights reserved.
        </div>
    </div>
</body>
</html>
