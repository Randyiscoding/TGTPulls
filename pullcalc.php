<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Priority Pull Calculator</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        font-family: Arial, sans-serif;
        background: #0f0c29;
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        color: white;
        padding: 20px;
        margin: 0;
    }

    h1 {
        text-align: center;
        font-size: 1.8em;
    }

    .container {
        background: rgba(255,255,255,0.1);
        padding: 20px;
        border-radius: 15px;
        max-width: 500px;
        margin: auto;
        backdrop-filter: blur(5px);
    }

    label {
        display: block;
        margin-top: 15px;
        font-size: 1.1em;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 8px;
        border: none;
        font-size: 1.1em;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 20px;
        background: #00dd90;
        color: #000;
        border: none;
        border-radius: 10px;
        font-size: 1.2em;
        font-weight: bold;
    }

    .result-box {
        margin-top: 20px;
        background: rgba(0,0,0,0.3);
        padding: 15px;
        border-radius: 10px;
    }

    .result-box p {
        font-size: 1.3em;
    }
</style>

</head>
<body>

<h1>Priority Pull Calculator</h1>

<div class="container">
    <label>Current Priority Count</label>
    <input type="number" id="priority" />

    <label>Priority Filled</label>
    <input type="number" id="priorityFilled" />

    <label>Goal Percentage (ex: 0.70)</label>
    <input type="number" step="0.01" id="goalPercentage" />

    <button onclick="calculate()">Calculate</button>

    <div id="results" class="result-box" style="display:none;">
        <p><b>Required Pulls:</b> <span id="basePulls"></span></p>
        <p><b>Adjusted for Guest Shopping:</b> <span id="bufferPulls"></span></p>
        <p><b>Staffing Recommendation:</b> <span id="staffRec"></span></p>
    </div>
</div>

<script>
function calculate() {
    const priority = parseFloat(document.getElementById("priority").value);
    const priorityFilled = parseFloat(document.getElementById("priorityFilled").value);
    const goal = parseFloat(document.getElementById("goalPercentage").value);

    if (isNaN(priority) || isNaN(priorityFilled) || isNaN(goal)) {
        alert("Please enter all values.");
        return;
    }

    const pullRate = 53.7887; // items Users are pulling per hour
    // above is based on puling 28 items in 31Mins, 13secs, 56ms
    const storeOpen = "07:00:00"; //Assuming your store opens at 7pm Everyday
    const storeClose = "22:00:00"; //Assuming your store closes at 10pm Everyday
    // TODO: add safety windows so calculations are usable after store hours
    // Current time
    const now = new Date();
    const nowStr = now.toTimeString().split(" ")[0];

    // Convert "HH:MM:SS" to Date objects for same day
    const today = new Date().toISOString().split("T")[0];
    const start = new Date(today + "T" + storeOpen);
    const end = new Date(today + "T" + storeClose);
    const current = new Date(today + "T" + nowStr);

    let hours = (current - start) / (1000 * 60 * 60);
    let close_hours = (end - current) / (1000 * 60 * 60);
    if (hours < 0.5) hours = 0.5; // prevent division explosion
    if (close_hours <= 0.5) close_hours = 0.5; // prevent division explosion Maybe??


    // PCR = priority creation rate
    const pcr = (priority + priorityFilled) / hours;

    // d = flow modifier
    const d = pcr / pullRate;

    // base requirement
    const required = (goal * (priority + priorityFilled)) - priorityFilled;

    // adjusted requirement
    const adjusted = required / (1 - goal * d);

    // Staffing Recommendation
    // TODO: Update PCR to match py
    const ptdpci = (priority + priorityFilled) + (pcr * close_hours)
    const staffrec = (goal * ptdpci)/(pullRate * close_hours)

    document.getElementById("basePulls").innerText = Math.ceil(required);
    if (adjusted < required){
    document.getElementById("bufferPulls").innerText = 0;
    }
    else{
        if(adjusted > (priority+priorityFilled)){
        document.getElementById("bufferPulls").innerText = priority+priorityFilled;
        }
        else{document.getElementById("bufferPulls").innerText = Math.ceil(adjusted);}
    }
    document.getElementById("staffRec").innerText = "We Recommend "+Math.ceil(staffrec)+" TMs to pull based on a projected "+Math.ceil(ptdpci)+" over the next "+close_hours.toFixed(2)+" hour(s)";
    document.getElementById("results").style.display = "block";
}
</script>

</body>
</html>
