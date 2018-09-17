function isPalindromes(str) {
  var newString = '';
  for (var i=str.length-1; i>=0; i--) {
    newString += str[i];  
 } 
  if (newString === str) {
  	return true;
  } else {
  	return false;
  }
}


console.log(isPalindromes('applppa'));

module.exports = isPalindromes