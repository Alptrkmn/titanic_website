<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titanic Veri Seti Üzerinde Tahmin Yapma</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <link rel="stylesheet" type="text/css" href="../src/style.css">

</head>
<body>

<h1>Titanic Alive or Dead Predictor</h1>

<form id="inputForm">
    <label for="pclass">Pclass:</label>
    <input type="number" id="pclass" name="pclass" required><br>

    <label for="sex">Sex:</label>
    <select id="sex" name="sex" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br>

    <label for="sibsp">SibSp:</label>
    <input type="number" id="sibsp" name="sibsp" required><br>

    <label for="parch">Parch:</label>
    <input type="number" id="parch" name="parch" required><br>

    <label for="fare">Fare:</label>
    <input type="number" id="fare" name="fare" required><br>

    <label for="embarked">Embarked:</label>
    <select id="embarked" name="embarked" required>
        <option value="C">C</option>
        <option value="Q">Q</option>
        <option value="S">S</option>
    </select><br>

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
            pclass: parseFloat(document.getElementById('pclass').value),
            sex: document.getElementById('sex').value,
            age: parseFloat(document.getElementById('age').value),
            sibsp: parseFloat(document.getElementById('sibsp').value),
            parch: parseFloat(document.getElementById('parch').value),
            fare: parseFloat(document.getElementById('fare').value),
            embarked: document.getElementById('embarked').value
        };
        
        console.log("Input Data:", inputData);

        inputData.sex = (inputData.sex === 'male') ? 0 : 1;
        inputData.embarked = (inputData.embarked === 'C') ? 0 : (inputData.embarked === 'Q') ? 1 : 2;

        inputTensor = tf.tensor([[
            [inputData.pclass],
            [inputData.sex],
            [inputData.age],
            [inputData.sibsp],
            [inputData.parch],
            [inputData.fare],
            [inputData.embarked]
        ]]);

        console.log("Input Tensor:", inputTensor.arraySync());
        const output = model.predict(inputTensor);
        const prediction = output.dataSync()[0];

        console.log("Prediction:", prediction);
        const resultElement = document.getElementById('result');
        

        resultElement.innerHTML = `Prediction: ${prediction}<br>Result: ${(prediction > 0.5) ? 'Alive' : 'Dead'}`;

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
