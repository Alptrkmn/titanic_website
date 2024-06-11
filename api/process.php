<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maternal Health Risk Predictor</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <link rel="stylesheet" type="text/css" href="../src/style.css">
</head>
<body>

<h1>Maternal Health Risk Predictor</h1>

<form id="inputForm">
    <label for="bodytemp">BodyTemp: </label>
    <input type="number" id="bodytemp" name="bodytemp" required><br>

    <label for="heartrate">Heart Rate:</label>
    <input type="number" id="heartrate" name="heartrate" required><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br>

    <label for="systolicbp">SystolicBP:</label>
    <input type="number" id="systolicbp" name="systolicbp" required><br>

    <label for="diastolicbp">DiastolicBP:</label>
    <input type="number" id="diastolicbp" name="diastolicbp" required><br>

    <label for="bs">BS:</label>
    <input type="number" id="bs" name="bs" required><br>

    <!-- <label for="embarked">Embarked:</label>
    <select id="embarked" name="embarked" required>
        <option value="C">C</option>
        <option value="Q">Q</option>
        <option value="S">S</option>
    </select><br> -->

    <button type="button" onclick="predict()">Predict</button>
</form>

<div id="result"></div>

<script>
    let inputTensor;

    async function loadModel() {
        try {
            const model = await tf.loadLayersModel('../src/tfjs_model/model.json');
            if (model) {
                console.log("Model Loaded");
                console.log("Loaded Model Summary:", model.summary()); 
                return model;
            } else {
                console.error("Model is not loaded.");
                return null;
            }
        } catch (error) {
            console.error("Error while loading model:", error);
            return null;
        }
    }

    async function predict() {
        const model = await loadModel();

        if (!model) {
            console.error("Model is not loaded.");
            return;
        }

        const inputData = {
            bodytemp: parseFloat(document.getElementById('bodytemp').value),
            age: parseFloat(document.getElementById('age').value),
            systolicbp: parseFloat(document.getElementById('systolicbp').value),
            diastolicbp: parseFloat(document.getElementById('diastolicbp').value),
            bs: parseFloat(document.getElementById('bs').value),
        };
        
        console.log("Input Data:", inputData);

        inputData.sex = (inputData.sex === 'male') ? 0 : 1;
        inputData.embarked = (inputData.embarked === 'C') ? 0 : (inputData.embarked === 'Q') ? 1 : 2;

        inputTensor = tf.tensor([[
            [inputData.bodytemp],
            [inputData.sex],
            [inputData.age],
            [inputData.systolicbp],
            [inputData.diastolicbp],
            [inputData.bs],
            [inputData.embarked]
        ]]);

        console.log("Input Tensor:", inputTensor.arraySync());
        const output = model.predict(inputTensor);
        const prediction = output.dataSync()[0];

        console.log("Prediction:", prediction);
        const resultElement = document.getElementById('result');

        resultElement.innerHTML = `Prediction: ${prediction}<br>Result: ${(prediction > 0.66) ? 'High Risk' : (prediction > 0.33 && prediction < 0.66) ? 'Mid Risk' : 'Low Risk'}`;

    }

    async function sendToPHP(prediction) {
        const response = await fetch('../src/script.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ prediction }),
        });

        const result = await response.json();
        console.log(result);
    }
</script>


</body>
</html>
