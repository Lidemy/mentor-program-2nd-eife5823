function printStars(n) {
  var str = '';
	for (var i=1; i<=n; i++){
    str += '*';   
	}
  return str;
}
function stars(n) {
    var arr = [];
	for (var i=1; i<=n; i++){
      arr.push(printStars(i));
	}
  return arr;
}
stars(4);
module.exports = stars;