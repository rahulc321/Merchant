<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Status</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f8fb;
            color: #444444;
        }
        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .email-body p {
            margin-bottom: 20px;
        }
        .table-container {
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .email-footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777777;
            background-color: #f9f9f9;
            border-top: 1px solid #dddddd;
        }
        .email-footer a {
            color: #2575fc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Task Status Update
        </div>
        <div class="email-body">
            <p>Hello <strong>{{ $task->end_user_name->full_name }}</strong>,</p>
            <p>
                Please find the details of your task below:
            </p>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Task Name</th>
                        <td>{{ $task->title }}</td>
                    </tr>
                    <tr>
                        <th>Agent Name</th>
                        <td>{{ $task->agent_name->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Agent Phone</th>
                        <td>{{ $task->agent_name->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Agent Email</th>
                        <td>{{ $task->agent_name->email }}</td>
                    </tr>
                    
                    <tr>
                        <th>Description</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Date and Time</th>
                        <td>{{ $task->due_date }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $task->status }}</td>
                    </tr>
                     
                </table>
            </div>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} CRM. All rights reserved. <br>
             
        </div>
    </div>
</body>
</html>
