<!DOCTYPE html>
<html>
<head>
<style>
ol {
    counter-reset: li; /* Initiate a counter */
    list-style: none; /* Remove default numbering */
    *list-style: decimal; /* Keep using default numbering for IE6/7 */
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol ol {
    margin: 0 0 0 2em; /* Add some left margin for inner lists */
}
.rounded-list a{
    position: relative;
    display: /*inline-*/block;
    padding: .4em .4em .4em 2em;
    *padding: .4em;
    margin: .5em 0;
    background: #ddd;
     
    color: #444;
    text-decoration: none;
    border-radius: .1em;
    transition: all .3s ease-out;   
}

.rounded-list a:hover{
    background: #eee;
}

.rounded-list a:hover:before{
    transform: rotate(360deg);  
}

.rounded-list a:before{
    content: counter(li);
    counter-increment: li;
    position: absolute; 
    left: -1.3em;
    top: 50%;
    margin-top: -1.3em;
    background: #87ceeb;
    height: 2em;
    width: 2em;
    line-height: 2em;
    border: .3em solid #fff;
    text-align: center;
    font-weight: bold;
    border-radius: 2em;
    
}

</style>
</head>
<body>
<ol class="rounded-list">
    <li><a href="">Обьект хандлагат програмчлал</a></li>
    <li><a href="">Програмчлалын үндэс</a></li>
    <li><a href="">Веб зохиомж</a>
      
            <li><a href="">Өгөгдлийн сангийн зохиомж</a></li>
            <li><a href="">Тархсан өгөгдлийнн сан</a></li>
            <li><a href="">Өгөгдлийн сангийн удирдлага</a></li>
        
    <li><a href="">Цахим засаглал</a></li>
    <li><a href="">Физик</a></li>
    <li><a href="">Түүх</a></li>                       
</ol>
</body>
</html>