class Countdown {
  constructor(el){
    this.el = el;
    this.targetDate = new Date(el.getAttribute("date-time") +' '+ template2_object.obj1);
    this.createCountDownParts()
    this.countdownFunction();
    this.countdownLoopId = setInterval(this.countdownFunction.bind(this), 1000)
  }
  createCountDownParts(){
    ["Days", "Hours", "Mins", "Secs"].forEach(part => {
      const partEl = document.createElement("div");
      partEl.classList.add("part", part);
      const textEl = document.createElement("div");
      textEl.classList.add("text");
      textEl.innerText = part;
      const numberEl = document.createElement("div");
      numberEl.classList.add("number");
      numberEl.innerText = 0;
      partEl.append(numberEl, textEl);
      this.el.append(partEl);
      this[part] = numberEl;
    })
  }

  countdownFunction(){
    const currentDate = new Date();    
    if(currentDate > this.targetDate) return clearInterval(this.intervalId);
    const remaining = this.getRemaining(this.targetDate, currentDate);
    Object.entries(remaining).forEach(([part,value]) => {
      this[part].style.setProperty("--value", value)
      this[part].innerText = value
    })  
  }
  
  getRemaining(target, now){
    let Secs = Math.floor((target - (now))/1000);
    let Mins = Math.floor(Secs/60);
    let Hours = Math.floor(Mins/60);
    let Days = Math.floor(Hours/24);
    Hours = Hours-(Days*24);
    Mins = Mins-(Days*24*60)-(Hours*60);
    Secs = Secs-(Days*24*60*60)-(Hours*60*60)-(Mins*60);
    if((Days == 0) && (Hours == 0) && (Mins == 0) && (Secs == 0)){
      setTimeout(function(){
        window.location.reload();
      },1000);
    }
    return { Days, Hours, Mins, Secs }      
  }

}

const countdownEls= document.querySelectorAll(".countdown") || [];
countdownEls.forEach(countdownEl => new Countdown(countdownEl))