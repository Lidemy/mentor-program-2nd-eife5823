function join(str, concatStr) {
  var result = '';
  for (var i=0; i<str.length; i++) {
    result += str[i] + concatStr;
  }
  return result.substr(0, result.length-1);
}

console.log(join(["a", "b", "c"], '!'));

function repeat (str, times) {
 var result = '';
 for (var i=1; i<=times; i++) {
   result += str;
  }
 return result;	
}

console.log(repeat('yoyo', 2));
