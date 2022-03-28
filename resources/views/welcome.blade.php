
              <!doctype html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lol Replays</title>
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      background-color: #fff;
      -webkit-text-size-adjust: 100%;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

   

    /* text-field */
    .text-field {
      margin-bottom: 1rem;
    }

    .text-field__label {
      display: block;
      margin-bottom: 0.25rem;
    }

    .text-field__input {
      display: block;
      width: 100%;
      height: calc(2.25rem + 2px);
      padding: 0.375rem 0.75rem;
      font-family: inherit;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #bdbdbd;
      border-radius: 0.25rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .text-field__input::placeholder {
      color: #212529;
      opacity: 0.4;
    }

    .text-field__input:focus {
      color: #212529;
      background-color: #fff;
      border-color: #bdbdbd;
      outline: 0;
      box-shadow: 0 0 0 0.2rem rgba(158, 158, 158, 0.25);
    }

    .text-field__input:disabled,
    .text-field__input[readonly] {
      background-color: #f5f5f5;
      opacity: 1;
    }
    .c-button {
  min-width: 100px;
  font-family: inherit;
  appearance: none;
  border: 0;
  border-radius: 5px;
  background: #4676d7;
  color: #fff;
  padding: 8px 16px;
  font-size: 1rem;
  cursor: pointer;
}

.c-button:hover {
  background: #1d49aa;
}

.c-button:focus {
  outline: none;
  box-shadow: 0 0 0 4px #cbd6ee;
}
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div style="max-width: 500px; margin-left: auto; margin-right: auto; padding: 15px;">

    <h1>Поиск реплеев игрока</h1>
   
    <div class="text-field">
      <label class="text-field__label" for="login">Введите ник игрока</label>
      <input class="text-field__input" type="text" name="nick" id="nick" placeholder="Nickname" >
      
      <button class="c-button" onclick="foo1()">Найти</button>
  
    </div>
    

  </div>

  <script>
        

function foo1(){
   fetch("https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/"+document.querySelector("input[name='nick']").value+"?api_key=RGAPI-8f35c3f1-f16d-4cbb-92ac-670fcff14b9a",

    { 
    method: "GET",  

    })
   
    .then( response =>  response.json().then(data=> ({body:data})))
    .then(obj => {
         fetch("https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/"+obj.body.puuid+"/ids?start=0&count=1&api_key=RGAPI-8f35c3f1-f16d-4cbb-92ac-670fcff14b9a",
        { 
            method: "GET",  

            })
       
        .then( res=>  res.json().then(data=> ({body:data})))
        .then(o => {  
           
             fetch("https://europe.api.riotgames.com/lol/match/v5/matches/"+o.body[0]+"/timeline?api_key=RGAPI-8f35c3f1-f16d-4cbb-92ac-670fcff14b9a",
                { 
                    method: "GET",  

                    })
               
                .then( res=>  res.json().then(data=> ({body:data})))
                .then(o => {  
                    
                    for(var i = 0; i < o.body.info.frames.length; i++) {
                        var obj = o.body.info.frames[i];
                        for(var w = 0; w < obj.events.length; w++) {
                             var bj =  obj.events[w];
                             if(bj['type']=="CHAMPION_SPECIAL_KILL" && bj['killType']=="KILL_FIRST_BLOOD"){
                                console.log(bj["timestamp"]);
                                const token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
                               
                                let url = '/runpython';
                                fetch(url, {
                                   headers: {
                                     "Content-Type": "application/json",
                                     "Accept": "application/json, text-plain, */*",
                                     "X-Requested-With": "XMLHttpRequest",
                                     "X-CSRF-TOKEN": token
                                    },
                                   method: 'post',
                                   credentials: "same-origin",
                                   body: JSON.stringify({
                                     time: bj["timestamp"]
                                   })
                                  })
                                   .then((data) => {
                                       console.log(data);
                                   })
                                  .catch(function(error) {
                                      console.log(error);
                                    });
                                  

                             }
                       }
                      //  console.log(obj.events);
                    }
                   // o.body.info.frames.find(x=> x["type"] == "CHAMPION_SPECIAL_KILL")
                   //  for(o.body.info.frames)
                   // console.log(o.body.info.frames)

                })

        })

    })
.catch(() => console.log('ошибка'));  
}
  </script>


</body>

</html>

