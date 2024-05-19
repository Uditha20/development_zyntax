<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateJob
    </title>
    <style>
        label {
            font-weight: bold;
        }
    </style>

</head>

<body>
    <?php
    require_once '../../headers/header.php'
        ?>
    <form>
        <div class="row">
            <div class="form-group col-md-5">
                <label for="inputState">Catogory</label>
                <select id="inputState" name="" class="form-control">
                    <option selected>Choose...</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="inputState">Company</label>
                <input type="text" name="" id="" class="form-control" placeholder="Company">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-5">
                <label for="inputState">Catogory</label>
                <select id="inputState" class="form-control">
                    <option selected>Choose...</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                    <option>1</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label>Payment</label>
                <input type="text" name="" id="" class="form-control" placeholder="Payment">
            </div>
        </div>
    </form>
    <div>
        <button class="btn btn-primary" name="">Register form</button>
    </div>

</body>

</html>