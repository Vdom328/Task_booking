<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>

<body>
    <div id="spinner">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
    <!-- MultiStep Form -->
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-md-offset-3">
            <form id="msform">
                <!-- progressbar -->
                <ul id="progressbar" class="ps-0 ">
                    <li class="active">Step 1</li>
                    <li>Step 2</li>
                    <li>Step 3</li>
                    <li>Review</li>
                </ul>
                <!-- fieldsets -->


                <fieldset>
                    <h2 class="fs-title">Step 1</h2>
                    <div class="mb-3">
                        <label for="meal" class="text-start col-12">Please select a meal <span
                                class="text-danger">*</span> </label>
                        <select class="form-select" id="meal">
                            @foreach ($meals as $meal)
                                <option value="{{ $meal }}">{{ $meal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="number_people" class="text-start col-12">Please enter number of people <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control " id="number_people" value="1" max="10"
                            min="1">
                        <p class="text-start col-12 text-danger error_number_people"></p>
                    </div>
                    <input type="button" name="next" class="next action-button step1-next" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Step 2</h2>
                    <div class="mb-3">
                        <label for="restaurant" class="text-start col-12">Please select a Restaurant <span
                                class="text-danger">*</span> </label>
                        <select class="form-select " id="restaurant">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 text-start">
                        <p class="text-danger error-step2"></p>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="button" name="next" class="next action-button step2-next" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Step 3</h2>
                    <div>
                        <div class="col-12 d-flex flex-wrap justify-content-between mb-3 ">
                            <div class="col-md-5">
                                <label class="text-start col-12">Please select a Dish <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-md-6 text-start">
                                <label>Please enter no. of servings <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div>
                            <div class="col-12 d-flex justify-content-between mb-3">
                                <div class="col-md-5 col-8">
                                    <select class="form-select  dish" id="dish">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-4">
                                    <div class="col-md-4 col-10">
                                        <input type="number" class="form-control col-2 quantity_dish" value="1"
                                            min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="list_dish">

                        </div>
                        <div class="col-12 text-start mb-3">
                            <button type="button" class="btn btn-outline-dark rounded-circle"
                                id="addDishButton">+</button>
                        </div>
                    </div>
                    <div class="col-12 text-start">
                        <p class="text-danger error-step3"></p>
                    </div>

                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="button" name="next" class="next action-button step3-next" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Review</h2>
                    <div class="col-12 text-start">
                        <div class="col-12 mb-3 d-flex">
                            <div class="col-md-4 col-6">Meal:</div><span id="value_meal"></span>
                        </div>
                        <div class="col-12 mb-3 d-flex">
                            <div class="col-md-4 col-6">No. Of. People:</div><span id="value_people_number"></span>
                        </div>
                        <div class="col-12 mb-3 d-flex">
                            <div class="col-md-4 col-6">Restaurant:</div><span id="value_restaurant"></span>
                        </div>
                        <div class="col-12 mb-3 d-flex">
                            <div class="col-md-4 col-6">Dishes:</div>
                            <div id="value_dish">

                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous"
                        value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="Submit" />
                </fieldset>
            </form>
        </div>
    </div>
    <!-- /.MultiStep Form -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite('resources/js/app.js')
    <script>
        $(document).ready(function() {

            let data = @json(getData());
            //jQuery time
            var current_fs, next_fs, previous_fs; //fieldsets
            var left, opacity, scale; //fieldset properties which we will animate
            var animating; //flag to prevent quick multi-click glitches
            $(document).on("click", ".next", function() {
                if (animating) return false;
                animating = true;
                // Perform Ajax call for Step 1
                if ($(this).hasClass("step1-next")) {
                    $('.error_number_people').html('');
                    $('#number_people').removeClass('is-invalid');
                    var number_people = $('#number_people').val();
                    if (number_people > 10 || number_people <= 0) {
                        animating = false;
                        $('#number_people').addClass('is-invalid');
                        $('.error_number_people').html('Maximum number of people is 10 or minimum is 1')
                        return;
                    }

                    if (getRestaurant() === false) {
                        animating = false;
                        $('#number_people').addClass('is-invalid');
                        $('.error_number_people').html('An error occurred!')
                        return;
                    }
                }

                if ($(this).hasClass("step2-next")) {
                    $('.error-step2').html('');
                    $('#restaurant').removeClass('is-invalid');
                    if ($('#restaurant').val() == '') {
                        animating = false;
                        $('#restaurant').addClass('is-invalid');
                        $('.error-step2').html('Please select a Restaurant')
                        return;
                    }

                    if (getDishs() === false) {
                        animating = false;
                        $('.error-step2').html('An error occurred!')
                        return;
                    }

                    $('#list_dish').html('');
                }

                if ($(this).hasClass("step3-next")) {
                    if (validateStep3() === false) {
                        animating = false;
                        return;
                    }
                    updateReview();
                }

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //activate next step on progressbar using the index of next_fs
                $("#progressbar li")
                    .eq($("fieldset").index(next_fs))
                    .addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0,
                }, {
                    step: function(now, mx) {
                        //as the opacity of current_fs reduces to 0 - stored in "now"
                        //1. scale current_fs down to 80%
                        scale = 1 - (1 - now) * 0.2;
                        //2. bring next_fs from the right(50%)
                        left = now * 50 + "%";
                        //3. increase opacity of next_fs to 1 as it moves in
                        opacity = 1 - now;
                        current_fs.css({
                            transform: "scale(" + scale + ")",
                            position: "absolute",
                        });
                        next_fs.css({
                            left: left,
                            opacity: opacity,
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_fs.hide();
                        animating = false;
                    },
                    //this comes from the custom easing plugin
                    easing: "easeInOutBack",
                });
            });

            $(document).on("click", ".previous", function() {
                if (animating) return false;
                animating = true;

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //de-activate current step on progressbar
                $("#progressbar li")
                    .eq($("fieldset").index(current_fs))
                    .removeClass("active");

                //show the previous fieldset
                previous_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0,
                }, {
                    step: function(now, mx) {
                        //as the opacity of current_fs reduces to 0 - stored in "now"
                        //1. scale previous_fs from 80% to 100%
                        scale = 0.8 + (1 - now) * 0.2;
                        //2. take current_fs to the right(50%) - from 0%
                        left = (1 - now) * 50 + "%";
                        //3. increase opacity of previous_fs to 1 as it moves in
                        opacity = 1 - now;
                        current_fs.css({
                            left: left,
                        });
                        previous_fs.css({
                            transform: "scale(" + scale + ")",
                            opacity: opacity,
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_fs.hide();
                        animating = false;
                    },
                    //this comes from the custom easing plugin
                    easing: "easeInOutBack",
                });
            });

            $(document).on("click", ".submit", function() {
                alert("Order successful!");
                return false;
            });

            function getRestaurant() {
                $.ajax({
                    url: "{{ route('getRestaurant') }}",
                    method: 'get',
                    data: {
                        meal: $('#meal').val(),
                        number_people: $('#number_people').val()
                    },
                    success: function(response) {
                        if (response == 'error') {
                            return false;
                        }
                        $('#restaurant').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        return false;
                    }
                });
                return true;
            };

            function getDishs(addDish = false) {
                $.ajax({
                    url: "{{ route('getDish') }}",
                    method: 'get',
                    data: {
                        meal: $('#meal').val(),
                        restaurant: $('#restaurant').val(),
                        addDish: addDish
                    },
                    success: function(response) {
                        if (addDish) {
                            $('#list_dish').append(response);
                        } else {
                            $('#dish').html(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
                return true;
            }

            $(document).on("click", "#addDishButton", function() {
                getDishs(addDish = true)
            });

            // Handle close button click event
            $('#list_dish').on('click', '.close-button', function() {
                $(this).closest('.form-dish').remove();
            });

            function updateArrayDish() {
                $('.error-step3').html('');
                var selectedDishes = [];
                $('.dish').each(function() {
                    var dishName = $(this).val();
                    var quantity = $(this).closest('.col-12').find('.quantity_dish').val();
                    var dishInfo = {
                        name: dishName,
                        quantity: quantity
                    };
                    selectedDishes.push(dishInfo);

                });

                // Check for duplicate dish names after creating the array
                var duplicateDishes = findDuplicateDishes(selectedDishes);
                if (duplicateDishes == true) {
                    $('.error-step3').html('Users cannot choose the same dish twice but add more servings.');
                }
                return selectedDishes;
            }

            $(document).on("change", ".dish", function() {
                updateArrayDish()
            });

            function findDuplicateDishes(dishes) {
                var seenNames = {};

                for (var i = 0; i < dishes.length; i++) {
                    var dishName = dishes[i].name;
                    if (dishName !== '') {
                        if (seenNames[dishName]) {
                            return true;
                        } else {
                            seenNames[dishName] = true;
                        }
                    }
                }

                return false;
            }

            function validateStep3() {
                let data = updateArrayDish();
                var duplicateDishes = findDuplicateDishes(data);
                if (duplicateDishes == true) {
                    $('.error-step3').html('Users cannot choose the same dish twice but add more servings.');
                    return false;
                }

                if (data.length > 10) {
                    $('.error-step3').html('A maximum of only 10 items is allowed.');
                    return false;
                }

                var totalServings = 0;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].name == '') {
                        $('.error-step3').html('Dishes cannot be left blank.');
                        return false;
                    }
                    if (data[i].quantity < 1) {
                        $('.error-step3').html('Food rations cannot be left blank.');
                        return false;
                    }

                    totalServings += parseInt(data[i].quantity);
                }

                if (totalServings < $('#number_people').val()) {
                    $('.error-step3').html('Total servings must be greater than or equal to ' + $('#number_people')
                        .val());
                    return false;
                }

                return true;
            }

            function updateReview() {
                $('#value_meal').html($("#meal").val());
                $('#value_people_number').html($("#number_people").val());
                $('#value_restaurant').html($("#restaurant").val());

                let data = updateArrayDish();
                let html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<p>' + data[i].name + ' - ' + data[i].quantity + '</p>';
                }
                $('#value_dish').html(html)
            }
        });
    </script>
</body>

</html>
