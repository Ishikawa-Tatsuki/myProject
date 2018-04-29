

function getBall(index){
	var object = document.getElementsByClassName('ball')[index];
	return object;
}

function animate_ball(object,v,a){

	var obj = object;
	var ticks = 0;
	var velocity = v;
	var acceleration = 0;
	var ac = a;
	var position_y = 0;
	var std_y = window.pageYOffset + obj.getClientRects()[0].top;
	var std_x = window.pageXOffset + obj.getClientRects()[0].left;
	var y = 0;
	obj.style.position = "absolute";

	animate();

	function animate(){

		ticks += 1;

			acceleration = y >= 0 ? -ac:ac;
			velocity += acceleration;
			y += 0.5 * acceleration + velocity;
			obj.style.top = std_y + y + "px";
		requestAnimationFrame(animate);
	}
}
animate_ball(getBall(0),7,0.2);
animate_ball(getBall(1),6,0.1);
animate_ball(getBall(2),7,0.1);
animate_ball(getBall(3),8,0.2);
