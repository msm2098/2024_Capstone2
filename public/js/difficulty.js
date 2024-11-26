document.getElementById('difficultyForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var difficulty = document.querySelector('input[name="difficulty"]:checked');
    var type = document.body.id;

    if (difficulty) {
        difficulty = difficulty.value;
        ///var url = "/problems/" + username + "/" + type + "/" + sessionValue + "_" + difficulty + ".php";
        var url="index.php?controller="+sessionValue+"&action=problem&type="+type+"&difficulty="+difficulty;
        window.location.href = url;
    } else {
        alert("난이도를 선택해주세요.");
    }
});
