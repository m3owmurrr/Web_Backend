<head>
    <meta charset="utf-8">
    <title> Задание 3 </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="task3.css">
</head>

<body>
    <div class="form_block container">
        <div class="form_panels d-flex flex-column align-items-center col-10 mx-auto" autocomplete="off">
            <div class="form_panel">
                <h1>Форма обратной связи </h1>
                <form action="" method="POST">
                    <div class="form_elem crutch">
                        <h5>Ваше имя</h5>
                        <input type="name" name="name" placeholder="введите имя">
                    </div>
                    <div class="form_elem crutch">
                        <h5>Куда отправлять вам спам</h5>
                        <input type="email" name="email" placeholder="введите эл. почту">
                    </div>
                    <div class="form_elem crutch">
                        <h5>День вашего появляения на свет</h5>
                        <input type="date" name="birthDate" value="1955-06-08">
                    </div>
                    <div class="form_elem ">
                        <h5>Ваш пол</h5>
                        <input type="radio" name="gender" value="Male">
                        <span>Мужской  &nbsp&nbsp</span>
                        <input type="radio" name="gender" value="Female">
                        <span>Женский  &nbsp&nbsp</span>
                        <input type="radio" name="gender" value="Other">
                        <span>USS DD-459 Laffey  &nbsp&nbsp</span>
                    </div>
                    <div class="form_elem">
                        <h5>Сколько конечностей</h5>
                        <input type="radio" name="numOfLimbs" value="0">
                        <span>0 &nbsp&nbsp</span>
                        <input type="radio" name="numOfLimbs" value="1">
                        <span>1 &nbsp&nbsp</span>
                        <input type="radio" name="numOfLimbs" value="2">
                        <span>2 &nbsp&nbsp</span>
                        <input type="radio" name="numOfLimbs" value="3">
                        <span>3 &nbsp&nbsp</span>
                        <input type="radio" name="numOfLimbs" value="4">
                        <span>4 &nbsp&nbsp</span>
                        <input type="radio" name="numOfLimbs" value=">4">
                        <span>>4 &nbsp&nbsp</span>
                    </div>
                    <div class="form_elem">
                        <h5>Суперспособности</h5>
                        <select name="superPower" multiple="multiple" >
                            <option value="value1"> Fire Resistance</option>
                            <option value="value2"> Regeneration</option>
                            <option value="value3"> Night Vision</option>
                            <option value="value4"> Invisibility</option>
                            <option value="value5"> Leaping</option>
                            <option value="value5"> Water Breathing</option>
                            <option value="value5"> Swiftness</option>
                        </select>
                    </div>
                    <div class="form_elem">
                        <h5>Похвалите себя </h5>
                        <textarea name="biography"></textarea>
                    </div>
                    <div class="form_elem">
                        <input name="check" type="checkbox">
                        <span>Согласен(а) со всем</span>
                    </div>
                    <div class="form_elem">
                        <input type="submit" value="Отправить">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>