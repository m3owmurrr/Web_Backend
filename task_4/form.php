<head>
    <meta charset="utf-8">
    <title> Задание 4 </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="task4.css">
</head>

<body>
    <div class="form_block container">
        <div class="form_panels d-flex flex-column align-items-center col-10 mx-auto" autocomplete="off">
            <div class="form_panel">
                <h1>Форма обратной связи </h1>
                <form action="" method="POST">


                    <div class="form_elem">
                        <h5>Ваше имя</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input type="name" name="name" placeholder="введите имя" class="crutch"
                                    value="<?php print $values['name']; ?>">
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['name'];
                                ?>
                            </div>
                        </div>

                    </div>


                    <div class="form_elem">
                        <h5>Куда отправлять вам спам</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input type="email" name="email" placeholder="введите эл. почту" class="crutch"
                                    value="<?php print $values['email']; ?>">
                            </div>
                            <div class="form_error col-6">
                                <?php
                                if (!empty($messages['email']))
                                    print $messages['email'];
                                ?>
                            </div>
                        </div>

                    </div>


                    <div class="form_elem">
                        <h5>День вашего появляения на свет</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input type="date" name="birthDate" class="crutch"
                                    value="<?php print $values['birthDate']; ?>">
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['birthDate'];
                                ?>
                            </div>
                        </div>

                    </div>


                    <div class="form_elem">
                        <h5>Ваш пол</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input type="radio" name="gender" value="Male" <?php if ($values['gender'] == "Male") {
                                    print 'checked';
                                } ?>>
                                <span>Мужской &nbsp&nbsp</span>
                                <input type="radio" name="gender" value="Female" <?php if ($values['gender'] == "Female") {
                                    print 'checked';
                                } ?>>
                                <span>Женский &nbsp&nbsp</span>
                                <input type="radio" name="gender" value="Other" <?php if ($values['gender'] == "Other") {
                                    print 'checked';
                                } ?>>
                                <span>USS DD-459 Laffey &nbsp&nbsp</span>
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['gender'];
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="form_elem">
                        <h5>Сколько конечностей</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input type="radio" name="numOfLimbs" value="0" <?php if ($values['numOfLimbs'] == "0") {
                                    print 'checked';
                                } ?>>
                                <span>0 &nbsp&nbsp</span>
                                <input type="radio" name="numOfLimbs" value="1" <?php if ($values['numOfLimbs'] == "1") {
                                    print 'checked';
                                } ?>>
                                <span>1 &nbsp&nbsp</span>
                                <input type="radio" name="numOfLimbs" value="2" <?php if ($values['numOfLimbs'] == "2") {
                                    print 'checked';
                                } ?>>
                                <span>2 &nbsp&nbsp</span>
                                <input type="radio" name="numOfLimbs" value="3" <?php if ($values['numOfLimbs'] == "3") {
                                    print 'checked';
                                } ?>>
                                <span>3 &nbsp&nbsp</span>
                                <input type="radio" name="numOfLimbs" value="4" <?php if ($values['numOfLimbs'] == "4") {
                                    print 'checked';
                                } ?>>
                                <span>4 &nbsp&nbsp</span>
                                <input type="radio" name="numOfLimbs" value="5" <?php if ($values['numOfLimbs'] == "5") {
                                    print 'checked';
                                } ?>>
                                <span>>4 &nbsp&nbsp</span>
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['numOfLimbs'];
                                ?>
                            </div>
                        </div>

                    </div>


                    <div class="form_elem">
                        <h5>Суперспособности</h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <select name="ability[]" multiple="multiple" class="crutch">
                                    <?php
                                    $arr = array(0);
                                    if (!empty($values['ability']))
                                        $arr = json_decode($values['ability']);
                                    ?>
                                    <?php
                                    foreach ($abilityArr as $key => $value) {
                                        $selected = in_array($key, $arr) ? 'selected' : '';
                                        print("<option value='$key' $selected>$value</option>");
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['ability'];
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="form_elem">
                        <h5>Похвалите себя </h5>
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <textarea name="biography" class="crutch"></textarea>
                            </div>
                            <div class="form_error col-6">
                            </div>
                        </div>
                    </div>


                    <div class="form_elem">
                        <div class="form_row row">
                            <div class="form_field col-6">
                                <input name="check" type="checkbox">
                                <span>Согласен(а) со всем</span>
                            </div>
                            <div class="form_error col-6">
                                <?php
                                print $messages['check'];
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="form_elem">
                        <input type="submit" value="Отправить">
                        <?php
                        print $messages['save'];
                        ?>
                    </div>


                </form>
            </div>
        </div>
    </div>
</body>