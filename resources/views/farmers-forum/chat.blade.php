
<style>
        /* Styles for the question list */
        .question-list {
            list-style-type: none;
            padding: 0;
        }

        .question-list li {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        /* Styles for the count */
        .answer-count {
            font-size: 14px;
            color: #888;
        }

        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            position: relative;
            width: 80%; /* Adjust the width as needed */
            max-width: 400px;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
        }

        #submit-answer {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h1>Questions</h1>
               
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#questionModal">
                   Ask a question
                </button>
            </div>
            <div class="card-body">
                <ul class="question-list">
                    <!-- loop through the questions and display them here -->

                    @foreach($questions as $question)
                    <li>
                        <h4>{{ $question->question }}</h4>
                        <p class="answer-count">
                            <a href="{{ admin_url('question_answers', ['id' => $question->id]) }}">
                                {{ $question->answers->count() }} answers
                            </a>
                        </p>
                        <button type="button" class="btn btn-primary btn-answer" data-toggle="modal" data-target="#exampleModal" data-question-id="{{ $question->id }}" data-question="{{ $question->question }}">
                            Answer
                        </button>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

    <!-- Modal for answering questions -->
    <div class="modal fade" id="exampleModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Answer:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                    <input type="hidden" id="question-id-input" name="question_id" value="">
                    <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-submit">Submit</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for questions -->
    <div class="modal fade" id="questionModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <h4 class="modal-title" id="exampleModalLabel">Ask Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form >
                        @csrf
                        <div class="form-group">
                            <label for="question" class="control-label">Question:</label>
                            <textarea class="form-control" id="question" name="question"></textarea>   
                        </div>
                            <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        //function to submit question
        $('#questionModal button[type="button"]').click(function (e) {
            e.preventDefault();
            var question = $('#question').val();
            var user_id = $('#user_id').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get the CSRF token from the meta tag

            $.ajax({
                url: "{{ route('store') }}",
                type: "POST",
                data: {
                    question: question,
                    user_id: user_id,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $('#questionModal').modal('hide');
                  //send toast notification
                    toastr.success(response.message);
                    //reload the page
                    location.reload();
                }
            });
        });

        $('#exampleModal').on('show.bs.modal', function (event) 
        {
            var button = $(event.relatedTarget); 
            var question = button.data('question'); 
            var modal = $(this);
            modal.find('.modal-title').text(question);
        });

        // Function to capture question_id when "Answer" button is clicked
        $('.btn-answer').click(function () {
            var questionId = $(this).data('question-id'); // Get the question ID from the clicked button
            $('#question-id-input').val(questionId); // Set the question ID as a hidden input value
        });

        // Function to submit answer
        $('#exampleModal .btn-submit').click(function (e) {
            e.preventDefault();
            var answer = $('#message-text').val();
            var question_id = $('#question-id-input').val();
            var user_id = $('#user_id').val(); // Make sure to retrieve the user_id
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get the CSRF token from the meta tag

            $.ajax({
                url: "{{ route('answers') }}",
                type: "POST",
                data: {
                    answer: answer,
                    user_id: user_id,
                    question_id: question_id,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $('#exampleModal').modal('hide');
                    //send toast notification
                    toastr.success(response.message);
                    //reload the page
                    location.reload();
                }
            });
        });

        
    </script>
