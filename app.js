const{
	createPool
} = require('mysql');

const pool = createPool({
	host: "localhost",
	user: "root",
	password: "",
	database: "zombiePHORIA",
	connectionLimit: 10
})

var express = require('express');
const { unzipSync } = require('zlib');
var app = express();
var serv = require('http').Server(app);
 
app.get('/',function(req, res) {
	res.sendFile(__dirname + '/client/game.html');
});
app.use('/client',express.static(__dirname + '/client'));
 
serv.listen(2000);
console.log("Server started.");


var SOCKET_LIST = {};
var GRID_SIZE = 1530; 
var FRAME_COUNTER=0;
// var TILE_SIZE = 32;
//  //map 
//   Map = function(grid){
// 	var self = { 
// 		grid:grid,
// 	}
// 	self.isPositionWall = function(pt){
// 		var gridX=Math.floor(pt.x / TILE_SIZE);
// 		var gridY=Math.floor(pt.y / TILE_SIZE);
// 		if(gridX < 0 || gridX >= self.grid[0].lenght)
// 			return true;
// 		if(gridY < 0 || gridY >= self.grid[0].length)
// 			return true;
// 		return self.grid[gridY][gridX];

// 	}
//  }
 
// var mapArray2D = []
// for(var i= 0; i <100; i++){
// 	mapArray2D =[];
// 	for(var j =0; j <100; j++){
// 		mapArray2D[i][j] = mapArray[i*100 + j]
// 	}
// }
 	



var Entity = function(){
	var self = {
		x:780,
		y:780,
		spdX:0,
		spdY:0,
		id:"",
	}
	self.update = function(){
		var oldX=self.x;
		var oldY=self.y;
		
		self.x += self.spdX;
		self.y += self.spdY;
		//colision
		checkPlayer  = checkCollision(self.x,self.y)
		 if(checkPlayer	){

		 	 self.x = oldX;
			 self.y = oldY;
	 
		}
	}
		
	
	self.updatePositionZombie = function(){
		
		//colision
		checkZombie = checkCollision(self.x,self.y)

		 if(checkZombie)
		 {
			temp = quarter(self.x,self.y);
			self.x += temp.x;
			self.y += temp.y;
			checkZombie = checkCollision(self.x,self.y)
		}
		else{
			self.x += self.spdX;
			self.y += self.spdY;
		}
	}
	self.updatePositionBullet = function(){
		var oldX=self.x;
		var oldY=self.y;
		self.x += self.spdX;
		self.y += self.spdY;
		//colision
		checkBullet = checkCollision(self.x, self.y);
		 if(checkBullet){
		 	 self.x= oldX;
			 self.y= oldY;
			 self.toRemove=true;
		}
	}
	self.getDistance = function(pt){
		return Math.sqrt(Math.pow(self.x-pt.x,2) + Math.pow(self.y-pt.y,2));
	}
	return self;
}

var Player = function(id){
	var self = Entity();
	self.id = id;
	self.number = "" + Math.floor(10 * Math.random());
	self.pressingRight = false;
	self.pressingLeft = false;
	self.pressingUp = false;
	self.pressingDown = false;
	self.pressingAttack = false;
	self.mouseAngle = 0;
	self.maxSpd = 5;
	self.hp=10;
	self.hpmax=10;
	self.score=0;
	self.lives=3;
	self.fireRate=30;
	self.timeAlive=0;
	self.attack=1;
 
	var super_update = self.update;
	self.update = function(){
		self.updateSpd();
		super_update();
 
		if(self.pressingAttack){
			if(FRAME_COUNTER % self.fireRate ===0)
				self.shootBullet(self.mouseAngle);
		}

	if(FRAME_COUNTER % 30 === 0)
		spawnZombie()
	if(FRAME_COUNTER % 100 === 0)
		spawnHp()
	}
	self.shootBullet = function(angle){
		var b = Bullet(self.id,angle);
		b.x = self.x;
		b.y = self.y;
	}
	spawnHp = function(){
		var h = Hp();
		h.x = Math.floor(Math.random() * GRID_SIZE)+1;
		h.y = Math.floor(Math.random() * GRID_SIZE)+1;
		checkHp = checkCollision(h.x, h.y)
     	while(checkHp){
				h.x = Math.floor(Math.random() * GRID_SIZE)+1;
				h.y = Math.floor(Math.random() * GRID_SIZE)+1;
				checkHp = checkCollision(h.x, h.y)
			}
		
	}
	spawnZombie = function(){
		var z = Zombie();
		z.x = Math.floor(Math.random() * GRID_SIZE)+1;
		z.y = Math.floor(Math.random() * GRID_SIZE)+1;
		check = checkCollision(z.x,z.y)
		while(check){
			z.x = Math.floor(Math.random() * GRID_SIZE)+1;
			z.y = Math.floor(Math.random() * GRID_SIZE)+1;
			check = checkCollision(z.x,z.y)
		}
	}
 
	self.updateSpd = function(){
		if(self.pressingRight)
			self.spdX = self.maxSpd;
		else if(self.pressingLeft)
			self.spdX = -self.maxSpd;
		else
			self.spdX = 0;
 
		if(self.pressingUp)
			self.spdY = -self.maxSpd;
		else if(self.pressingDown)
			self.spdY = self.maxSpd;
		else
			self.spdY = 0;		
	}




	self.getInitPack= function(){
		return{
			id: self.id,
			x:self.x,
			y:self.y,
			score:self.score,
			lives:self.lives,
			timeAlive:self.timeAlive,
		}
	}
	Player.list[id] = self;

	initPack.push({id: self.id});
	return self;
}

Player.list = {};
Player.onConnect = function(socket){
	var player = Player(socket.id);
	player.timeAlive= Date.now();
	socket.on('keyPress',function(data){
		if(data.inputId === 'left')
			player.pressingLeft = data.state;
		else if(data.inputId === 'right')
			player.pressingRight = data.state;
		else if(data.inputId === 'up')
			player.pressingUp = data.state;
		else if(data.inputId === 'down')
			player.pressingDown = data.state;
		else if(data.inputId === 'attack')
			player.pressingAttack = data.state;
		else if(data.inputId === 'mouseAngle')
			player.mouseAngle = data.state;
		})
			socket.emit('init',{
				selfId:socket.id,
				 player:Player.getAllInitPack(),
			})

}	
		
Player.getAllInitPack = function(){
			var players = [];
			for(var i in Player.list)
				players.push(Player.list[i].getInitPack());
			return players;
		}


Player.onDisconnect = function(socket){
	delete Player.list[socket.id];
}
Player.update = function(){
	var pack = [];
	for(var i in Player.list){
		var player = Player.list[i];
		player.update();
		pack.push({
			id:player.id,
			x:player.x,
			y:player.y,
			number:player.number,
			hp:player.hp,
			hpmax:player.hpmax,
			score:player.score,
			lives:player.lives,
			timeAlive:player.timeAlive,
		});		
	}
	return pack;
}
 
 
var Bullet = function(parent,angle){
	var self = Entity();
	
	self.id = Math.random();
	self.spdX = Math.cos(angle/180*Math.PI) * 10;
	self.spdY = Math.sin(angle/180*Math.PI) * 10;
	self.parent = parent;
	self.timer = 0;
	self.toRemove = false;
	var super_update = self.updatePositionBullet;
	self.update = function(){
		if(self.timer++ > 100)
			self.toRemove = true;
		super_update();
 
		for(var i in Player.list){
			var p = Player.list[i];
			for(var j in Zombie.list){
				var z = Zombie.list[j]
			if(self.getDistance(p) < 32 && self.parent !== p.id){
				//handle collision: hp--;
					p.hp -= p.attack;
				
					if(p.hp <=0){			//if someone is dead reset his position,score and hp and give a score to the other player
						p.hp = p.hpmax;
						checkC = checkCollision(p.x, p.y);
						while(checkC){
								p.x=Math.random()*(GRID_SIZE-50)+50;
								p.y=Math.random()*(GRID_SIZE-30)+30;
								checkC = checkCollision(p.x, p.y);
							}
						p.lives-=1;
						var shooter = Player.list[self.parent]
						if(shooter)				
						shooter.score +=1;
					}
				self.toRemove = true;
			}

			if(self.getDistance(z) < 32){
				//handle collision: hp--;
					z.hp -= p.attack;
					if(z.hp <=0){			//if someone is dead reset his position,score and hp and give a score to the other player
						z.hp = z.hpmax;
						z.toRemove=true;
						spawnZombie();
						var shooter = Player.list[self.parent]
						if(shooter)				
						shooter.score +=1;
					
					}
				self.toRemove = true;
			}
		}
	}
}
	Bullet.list[self.id] = self;
	return self;
}
Bullet.list = {};
 
Bullet.update = function(){
	var pack = [];
	for(var i in Bullet.list){
		var bullet = Bullet.list[i];
		bullet.update();
		if(bullet.toRemove)
			delete Bullet.list[i];
		else
			pack.push({
				x:bullet.x,
				y:bullet.y,
			});		
	}
	return pack;
}
 //let hpAid= [{ x:10, y:10},]
//spawning hp aids in every 5000ms
// setInterval(function(){
// 	let newhpAid;
// 	hpAid=randomGridPosition();
// },5000)
var Hp=function(){
	//console.log("asdasd")
	var self=Entity();
	self.id = Math.random();
	self.x=500;
	self.y=500;
	 self.toRemove=false;
	 var super_update= self.update;
	 self.update = function(){
	 	super_update();
	
	 for(var i in Player.list){
	 	var p = Player.list[i];
	 	if(self.getDistance(p) < 32 && self.parent !== p.id){
			 //handle collision: hp+5;
			 if(p.hp<10){
				p.hp += 5;
				self.toRemove=true;
				checkHp = checkCollision(self.x,self.y)
					   while(checkHp){
						   self.x=Math.random()*(GRID_SIZE-50)+50;
						   self.y=Math.random()*(GRID_SIZE-30)+30;
						   checkPlayer = checkCollision(self.x,self.y)
					   }
				}
	 		}
	 	}
	 }
	Hp.list[self.id] = self;
	return self;
}

Hp.list = {};
Hp.update = function(){
	var pack = [];
	for(var i in Hp.list){
		var hp = Hp.list[i];
		hp.update();
		if(hp.toRemove)
			delete Hp.list[i];
		else
			pack.push({
				x:hp.x,
				y:hp.y,
			});		
	}
	return pack;
}
///////////////////Zombie
var moveToClosestPlayer = function(x,y){
	var cordinates ={
		up:false,
		down:false,
		right:false,
		left:false,
	}
	var tempX=0;
	var tempY=0;
	var tempDistance = 100000;
	for(var i in Player.list){
		var p= Player.list[i]
		var distance = Math.sqrt(Math.pow(x-p.x,2) + Math.pow(y-p.y,2))
		if(tempDistance >= distance ){
			tempDistance = distance
			tempX=p.x;
			tempY=p.y;
		}
	}
	if(tempX>x){
		cordinates.right=true;
		cordinates.left=true;
	}
	if (tempX<x){
		cordinates.left=true;
		cordinates.right=false;
	}
	if (tempY<y){
		cordinates.up=true;
		cordinates.down=false;
	}
	if (tempY>y){
		cordinates.down=true;
		cordinates.up=false;
	}
	return cordinates;
}
checkCollision = function(x,y){
	if(y <= 30 || y > 1530 || x >= 1550 || x <= 50 || 
		((385 < x && x < 600) && (520 < y && y < 585)) ||
		((250 < x && x < 530) && (285 < y && y < 348)) ||
		((410 < x && x < 560) && (120 < y && y < 185)) || 
		
		((750 < x && x < 815) && 360 > y) || 
		(x > 1190 && (755 < y && y < 820)) || 
		((750 < x && x < 810) && (1180 < y)) || 
		((x < 370) && (820 > y && y > 755)) ||
		
		((170 < x && x < 230) && (965 < y && y < 1030))  || 
		((200 < x && x < 260) && (1185 < y && y < 1250)) || 
		((265 < x && x < 325) && (1370 < y && y < 1440)) || 
		((395 < x && x < 445) && (1100 < y && y < 1165)) || 
		((590 < x && x < 640) && (1035 < y && y < 1105)) || 	
		((485 < x && x < 530) && (1305 < y && y < 1357)) || 
		((560 < x && x < 615) && (1465 < y && y < 1530)) ||
		
		((y <= 1316 && y > 1124) && (x >= 948 && x <= 1164)) ||  
		((y <= 1184 && y > 1032) && (x >= 1076 && x <= 1196)) ||   
		((y <= 1524 && y > 1462) && (x >= 1330 && x <= 1484)) ||   
		((y > 508 && y <= 632) && (x >= 884 && x <= 988)) ||   
		((y > 552 && y <= 644) && (x >= 1300 && x <= 1372)) ||  
		((y > 204 && y <= 316) && (x >= 1212 && x <= 1316)) ||  
		((y > 56 && y <= 148) && (x >= 932 && x <= 1000)) 								
		){
				return true;
		}
		return false;
 }
 quarter = function(x,y){
	var direction={
		x: 0,
		y:0,
	}
	if(x< 645&& y<755){	//dirt
		direction.x=0.5;
		direction.y=0;
	}
	if(x> 645&& y<755 && y<1530){	//woods
		direction.x=0;
		direction.y=0.5;
	}

	if(x < 675&& y> 820 && y< 1530){//pumpk
		direction.x=0.5;
		direction.y=0.5;
	}
	if(x < 395&& y < 840 && y>715 ){	//pumpk - dirt
		direction.x=0.5;
		direction.y=0;;
	}
	if(x > 675&& y > 820 && x<845 ){	//pumpk+lav1	polaczenie
		direction.x=0;
		direction.y=-0.5;
	}
	if(x > 675&& y > 820 && y< 1171&& x<840 ){ //pumpk+lav2da
		direction.x=0;
		direction.y=-0.5;
	}
	if(x > 925&& y > 1171 && y < 1380 && x<1200 ){	//pumpk+lav3
		direction.x=0;
		direction.y=0.5;
	}
	if(x > 955&& y > 1320  && x<1200 ){	//pumpk+lav3
		direction.x=-0.5;
		direction.y=0;
	}
	if(y< 900&& y > 750 && x>1100 ){	//lavaTOP
		direction.x= -0.5;
		direction.y=-0;
	}
	if(x >950 && y > 1010 && y < 1200 && x<1200 ){	//little
		direction.x=-1;
		direction.y= -1;
	}
	return direction;
}
var Zombie=function(){
	//console.log("asdasd")
	var self=Entity();
	self.hp=10;
	self.hpmax=10;
	self.id = Math.random();
	self.maxSpd =0.51;
	 self.toRemove=false;
	 var super_update= self.updatePositionZombie;
	 self.update = function(){
		if(FRAME_COUNTER % 30 === 0)
			self.updateSpd();
		super_update();
		for(var i in Player.list){
			var p = Player.list[i];
			if(self.getDistance(p) < 32){
					p.hp -= 2;
					if(p.hp <=0){			//if someone is dead by zombie
						p.hp = p.hpmax;
						p.x=Math.random()*(GRID_SIZE-50)+50;
						p.y=Math.random()*(GRID_SIZE-30)+30;
						checkC = checkCollision(p.x, p.y);
						while(checkC){
								p.x=Math.random()*(GRID_SIZE-50)+50;
								p.y=Math.random()*(GRID_SIZE-30)+30;
								checkC = checkCollision(p.x, p.y);
							}
						p.lives-=1;
						//p.score=0;
					}
				self.toRemove = true;
		}
		// if(FRAME_COUNTER % 30 === 0)
		// zombieFollow()
	 }}
	self.updateSpd = function(){
		var directions = moveToClosestPlayer(self.x,self.y);
		if(directions.right)
			self.spdX = self.maxSpd;
		else if(directions.left)
			self.spdX = -self.maxSpd;
		else
			self.spdX = 0;
 
		if(directions.up)
			self.spdY = -self.maxSpd;
		else if(directions.down)
			self.spdY = self.maxSpd;
		else
			self.spdY = 0;		

	}


	Zombie.list[self.id] = self;
	return self;
}

Zombie.list = {};
Zombie.update = function(){
	var pack = [];
	for(var i in Zombie.list){
		var zombie = Zombie.list[i];
		zombie.update();
		if(zombie.toRemove)
			delete Zombie.list[i];
		else
			pack.push({
				x:zombie.x,
				y:zombie.y,
			});		
	}
	return pack;
}
/*
setId = function(){
    pool.query(`select id from uzytkownicy where ingame = 1`, function(err, result, fields)  {
        if (err) {
            return console.log(err);
        }
		return result[0].id;
        return console.log(result)
    })
    pool.query(`update uzytkownicy set ingame = 0 where ingame = 1`, function(err)  {
        if (err) {
            return console.log(err);
        }

    })  
}*/
 
var io = require('socket.io')(serv,{});
io.sockets.on('connection', function(socket){
	//socket.id = Math.random();
	pool.query(`select * from uzytkownicy where logged_in = 1`, function(err, result, fields) {
    if (err) {
        return console.log(err);
    }
	socket.id = result[0].id;
	var id_loc = socket.id;
	if(socket.id !== undefined){
		console.log("player id: " + socket.id);
		pool.query(`update uzytkownicy set logged_in=0 where id=?`,[socket.id], function(err) {
		if (err) {
			return console.log(err);
		}
		})
	}
	SOCKET_LIST[socket.id] = socket;
 
	Player.onConnect(socket);
	if(result[0].chosen_class == 0)
	console.log("chosen class: nothing");
	if(result[0].chosen_class == 1){ //sniper
		Player.list[socket.id].hpmax = 7;
		Player.list[socket.id].fireRate = 20;
		Player.list[socket.id].attack = 10;
		Player.list[socket.id].maxSpd = 5;
		console.log("chosen class: sniper");
	}
	if(result[0].chosen_class == 2){ //heavy
		Player.list[socket.id].hpmax = 4;
		Player.list[socket.id].fireRate = 15;
		Player.list[socket.id].attack = 5;
		Player.list[socket.id].maxSpd = 4;
		console.log("chosen class: heavy");
	}
	if(result[0].chosen_class == 3){ //speedy
		Player.list[socket.id].hpmax = 10;
		Player.list[socket.id].fireRate = 10;
		Player.list[socket.id].attack = 2;
		Player.list[socket.id].maxSpd = 9;
		console.log("chosen class: speedy");
	}

 
	socket.on('disconnect',function(){
		pool.query(`update uzytkownicy set logged_in=1, xp=xp+? where id=?`,[Player.list[socket.id].score ,socket.id], function(err) {
		if (err) {
			return console.log(err);
		}
		})
		
		pool.query(`select * from uzytkownicy where id = ?`, [socket.id], function(err, result, fields) {
		if (err) {
			return console.log(err);
		}
		if (result[0].xp == 1000 || result[0].xp > 1000)
		{
			var lvl = result[0].lvl + 1;
			var xp = result[0].xp - 1000;
			var devotion_lvl = result[0].devotion_lvl;
			var pomoc = 0;
			if (lvl == 100){
				lvl = 1;
				devotion_lvl = devotion_lvl + 1;
				pomoc = 99;
			}
			var currency = result[0].currency + ((lvl + 99) * 100 * (devotion_lvl + 1))

			
			pool.query(`update uzytkownicy set xp=?, lvl=?, devotion_lvl=?, currency=? where id = ?`,[xp, lvl, devotion_lvl, currency, socket.id] , function(err) {
			if (err) {
				return console.log(err);
			}
			})
		}

			return result[0].id;
		})
		
		delete SOCKET_LIST[socket.id];
		Player.onDisconnect(socket);
	});
	
	socket.on('sendMsgToServer',function(data){
		var playerName = ("    " + result[0].user).slice(2,15);
		for(var i in SOCKET_LIST){
			SOCKET_LIST[i].emit('addToChat',playerName + ': ' + data);
		}
	});
 
	socket.on('evalServer',function(data){
		if(!DEBUG)
			return;
		var res = eval(data);
		socket.emit('evalAnswer',res);		
	});
 
 
	return console.log("nick: " + result[0].user);
})

});

var initPack = []
setInterval(function(){
	var pack = {
		player:Player.update(),
		bullet:Bullet.update(),
		hp:Hp.update(),
		zombie:Zombie.update(),
		
	}
 
	for(var i in SOCKET_LIST){
		var socket = SOCKET_LIST[i];
		socket.emit('newPositions',pack);
	    //socket.emit('init',initPack);
	}
	initPack=[];
	FRAME_COUNTER++;
},1000/60);