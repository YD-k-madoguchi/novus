function update() {
  gameTimer = setTimeout(update, 10);
  var lifeBar = document.getElementById('lifeBar');
  lifeBar.value++;
    
  //最大値に達したらループ終了
  if(lifeBar.value >= lifeBar.max){
  clearTimeout(gameTimer);
  }
    
  }
  
  update();