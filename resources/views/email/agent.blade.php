<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assigned</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="background-color: #4caf50; color: #ffffff; text-align: center; padding: 20px; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 24px;"> 🎉Congratulation Task Assigned 🎉 </h1>
        </div>
        <!-- Body -->
        <div style="padding: 20px; color: #333333;">
            <p style="font-size: 16px;">Dear <strong>{{$end_user->full_name}}</strong>,</p>
            <p style="font-size: 16px;">
                A new task has been assigned to you by the admin. Please find the details below:
            </p>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background-color: #f9f9f9;border: 1px solid;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Task Title:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $newTask->title }}</td>
                </tr>

               

                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Client Name:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $end_user->full_name }}</td>
                </tr>

                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Client Phone:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $end_user->phone_number }}</td>
                </tr>

                 <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Client Name:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $end_user->email }}</td>
                </tr>

                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Client Address:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $end_user->address }}</td>
                </tr>

                <tr>
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Description:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $newTask->description }}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Date and Time:</td>
                    <td style="padding: 10px;border: 1px solid;">{{ $newTask->due_date }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold;border: 1px solid;">Priority:</td>
                    <td style="padding: 10px;border: 1px solid;">High</td>
                </tr>
            </table>
            <p style="font-size: 16px;">
                Please make sure to complete the task by the deadline. If you have any questions, feel free to reach out to the admin.
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
