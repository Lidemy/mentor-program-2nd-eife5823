function alphaSwap(str) {
  var result = '';
  for (i=1; i<=str.length; i++){
  	if (str[i] >= 'a' && str[i] <= 'z') {
  		result += str[i].toUpperCase();
  	} else if (str[i] >= 'A' && str[i] <= 'Z') {
  		result += str[i].toLowerCase();
  	} else {
  		result += str[i];
  	}
  }
  return result;
}

console.log(alphaSwap(nick));

module.exports = alphaSwap