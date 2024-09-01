<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answers</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file here -->
    <style>
        /* Add CSS for separating answers with lines */
        .answer_list {
            border-bottom: 1px solid #ccc; /* Add a bottom border to create lines between answers */
            padding-bottom: 20px; /* Adjust the spacing as needed */
            margin-bottom: 20px; /* Adjust the spacing as needed */
        
        }

        .answer_profile {
            display: flex; /* Use flexbox for layout */
        }

        .user-image {
            width: 50px; /* Set the width and height to create a circular image */
            height: 50px;
            border-radius: 50%; /* Make the image circular */
            margin-right: 10px; /* Add spacing between the image and text */
        }

        .user-info {
            flex-grow: 1; /* Allow the text to expand and fill the available space */
        }

        .user-name {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <a href="javascript:history.back()" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 2.646a.5.5 0 0 1 0 .708L7.707 7H14.5a.5.5 0 0 1 0 1H7.707l3.647 3.646a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z"/>
                    </svg> Back
                </a>
                <h1>{{$question}}</h1>
            </div>
            <div class="card-body">
                <!-- Loop through the answers and display them here -->
                @foreach($answers as $answer)
                @php
                 $user = App\Models\User::find($answer->user_id);
                 $date = $answer->created_at->format('Y-m-d'); // Format it as 'YYYY-MM-DD HH:MM:SS'
                @endphp
                <div class="answer_list">
                    <div  class="answer_profile">
                    <img src="{{ asset('storage/' . ($user->avatar ?? 'images/user.jpg')) }}" alt="User Image" class="user-image">

                    <div class="user-info">
                        <p class="user-name">{{ $user->name }}</p>
                        <p class="question-date">Date: {{ $date }}</p>
                    </div>
                  
                </div>
                <p class="answer-text">{{ $answer->answer }}</p>
              </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
