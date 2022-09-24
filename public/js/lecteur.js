const createAudioLecture = ({link, repetition, container, title} ) =>{
    container.innerHTML='';
    const div = document.createElement('div');
    const play = document.createElement('button');
    play.innerHTML=">>";
    play.classList.add("play");
    const h1 = document.createElement('h1');
    const audio = document.createElement('audio');
    const control = document.createElement('div');
    h1.innerHTML = title;
    // audio.id="lesson" ;
    audio.crossOrigin="anonymous" ;
    // audio.autoplay="true";
    audio.src=link;
   audio.type="audio/mpeg";
   div.appendChild(h1);
   div.appendChild(audio);
   const bar =' <div class="progress">'+
                    '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >'+
                        '<span class="sr-only"></span>'+
                    '</div> '+
                    '<span class="progress-text">0%</span>'+
               '</div>'
               ;
    control.innerHTML = bar;
    control.appendChild(play);
    div.appendChild(control);
    container.appendChild(div);
    let number_repeated = 0;
    const appel = () => {
        let progress = document.querySelector('.sr-only');
        let text = document.querySelector('.progress-text');
        let currentTime = audio.currentTime;
        let duration = audio.duration;
        let percent = (currentTime/duration) * 100;
        progress.style.width = percent + '%';
        text.innerHTML = Math.round(percent) + '%';
    }

    play.addEventListener('click', function(){
        audio.innerHTML="||";
        // audio.crossOrigin = "anonymous";
        if(number_repeated<repetition){
            audio.play();
            number_repeated++;
            console.log(audio.currentTime,' ', audio.duration,' nombre de repetion:', number_repeated);
            audio.disabled=true;
            let time = setInterval(function(){
                appel();
                if(audio.ended){
                    clearInterval(time);
                    play.innerHTML=">>";
                    audio.disabled=false;
                }
            },1000);
        }  
        // if(number_repeated>repetition)audio.disabled=true;  
        else  this.innerHTML=">>";
    });

}

const createAudioNormal = ({link, container, title} ) =>{
    container.innerHTML='';
    const div = document.createElement('div');
    const play = document.createElement('button');
    play.classList.add("play");
    const h1 = document.createElement('h1');
    const audio = document.createElement('audio');
    const control = document.createElement('div');
    h1.innerHTML = title;
    audio.id="lesson" ;
    audio.crossOrigin="anonymous" ;
    audio.controls = true;
    audio.src=link;
   audio.type="audio/mpeg";
   div.appendChild(h1);
   div.appendChild(audio);
   container.appendChild(div);
}

const createVideoNormal = ({link, container, title} ) =>{
    container.innerHTML='';
    const div = document.createElement('div');
    const play = document.createElement('button');
    play.classList.add("play");
    const h1 = document.createElement('h1');
    const video = document.createElement('video');
    //const control = document.createElement('div');
    h1.innerHTML = title;
    video.id="lesson" ;
    video.crossOrigin="anonymous" ;
    video.controls = true;
    video.src=link;
   video.type="video/mp4";
   div.appendChild(h1);
   div.appendChild(video);
   container.appendChild(div);
}

const createVideoLecture = ({link, repetition, container, title} ) =>{
    container.innerHTML='';
    const div = document.createElement('div');
    const play = document.createElement('button');
    play.innerHTML=">>";
    play.classList.add("play");
    const h1 = document.createElement('h1');
    const video = document.createElement('video');
    const control = document.createElement('div');
    h1.innerHTML = title;
    // video.id="lesson" ;
    video.crossOrigin="anonymous" ;
    // audio.autoplay="true";
    video.src=link;
    video.classList.add('video');
    video.innerHTML="<source src='"+link+"' />";
   video.type="video/mp4";
   div.appendChild(h1);
   div.appendChild(video);
   const bar =' <div class="progress">'+
                    '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >'+
                        '<span class="sr-only"></span>'+
                    '</div> '+
                    '<span class="progress-text">0%</span>'+
               '</div>'
               ;
    control.innerHTML = bar;
    control.appendChild(play);
    div.appendChild(control);
    container.appendChild(div);
    let number_repeated = 0;
    const appel = () => {
        let progress = document.querySelector('.sr-only');
        let text = document.querySelector('.progress-text');
        let currentTime = video.currentTime;
        let duration = video.duration;
        let percent = (currentTime/duration) * 100;
        progress.style.width = percent + '%';
        text.innerHTML = Math.round(percent) + '%';
    }

    play.addEventListener('click', function(){
        play.innerHTML="||";
        // audio.crossOrigin = "anonymous";
        console.log('playing...')
        if(number_repeated<repetition){
            video.play();
            number_repeated++;
            console.log(video.currentTime,' ', video.duration,' nombre de repetion:', number_repeated);
            play.disabled=true;
            let time = setInterval(function(){
                appel();
                if(video.ended){
                    clearInterval(time);
                    play.innerHTML=">>";
                    play.disabled=false;
                }
            },1000);
        }  
        // if(number_repeated>repetition)audio.disabled=true;  
        else  play.innerHTML=">>";
    });

}