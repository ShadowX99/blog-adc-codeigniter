<?php

    /**
     *  Trivia API talk- Using CodeIgniter Framework supporting REST API.
     *
     * @category Blog
     * @package  Trivia
     * @author   Arefat Hyeredin
     */

    ?>

<!-- Custom Styling -->
    <style>
        #selAnswers div{
            
            border: 1px solid black;
            padding:10px;
            margin:5px;
            display: inline-block;
        }
        .cat{font-size: 1.0em;}
        .que{font-size: 1.5em;}
    </style>
<!-- Custom Styling  -->

<body>

<?php 

/**
 * Testing out Open Trivia API using AJAX.
 * 
 *          It talks with the trivia's api, by requesting questions from the API,
 *          that is then displayed with also a score being kept for every answer.
 */

?>  
<br>
    <h1>Trivia OpenTDB API talk with AJAX</h1>
    <div class="text-success">Score : <span id="score"> Correct 0 ****  Wrong 0</span></div>
    <div id="output"></div>
    <div id="selAnswers"></div>
    <button type="button" class="btn btn-success"id="btn">Click Me for More Trivia Questions</button>

<br><br><br><br>
<br><br><br><br>
<br><br><br><br>
<br><br><br><br>

<script>
        /**
         * @var
         *  btn
         */
        //Assign element with id button to var btn
        var btn = document.getElementById('btn');
        btn.addEventListener('click', nextItem)
        //listen click event for next question
        var answers = {
            'correct': 0
            , 'wrong': 0
        }
        //output the fetched content
        var output = document.getElementById('output');
        var selAnswer = document.getElementById('selAnswers')
        function nextItem() {
            btn.style.display = 'none'
            //Opentdb's API url
            var url = 'https://opentdb.com/api.php?amount=1';
            var html = ' '
            requestAJAX(url, function (data) {
                console.log(data.results[0]);
                var obj = data.results[0];
                //crete questions view
                html += '<div><div class="text-info" class="cat">' + obj.category + '</div>';
                html += '<div class="text-warning que" class="que">' + obj.question + '</div>';
                html += '</div>'
                output.innerHTML = html;
                questionBuilder(obj.correct_answer,obj.incorrect_answers)
            })
        }

        //Check correct answer
        function correctAnswerIs(){
            var els = document.querySelectorAll('#selAnswers div')
            for(x=0;x<els.length;x++){
                if(els[x].getAttribute('data-cor')=="true"){
                    return els[x].innerText
                }
            }
        }
        
        //Is answer correct or not?
        function sendAnswer(){
            var res = event.target.getAttribute('data-cor');
            var corectAnswerValue = correctAnswerIs();
            btn.style.display = 'block'
            if(res=='true'){
                answers.correct ++;
                selAnswer.innerHTML = 'Correct!! It is '+corectAnswerValue
            
            }else{
                answers.wrong ++;
                selAnswer.innerHTML = 'Wrong, It was  '+corectAnswerValue
            }
            document.getElementById('score').innerHTML = 'Correct '+ answers.correct+' Wrong '+answers.wrong
        }
        
        /**
         * Build question checker and layout
         */
        function questionBuilder(cor,incor){
            var holder = incor;
            holder.push(cor);
            holder.sort();
            
            selAnswer.innerHTML = '';
            for(var x=0;x<holder.length;x++){
                var el = document.createElement('div')
                var checker = holder[x] == cor ? true :false;
                el.setAttribute('data-cor',checker);
                el.innerHTML= holder[x];
                el.addEventListener('click',sendAnswer)
                selAnswer.appendChild(el);
            }
        }
        
        /** JSON Parse new content from the API */
        function requestAJAX(url, callback) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    callback(JSON.parse(xhr.responseText))
                }
            }
            xhr.open('GET', url, true)
            xhr.send();
        }
</script>
