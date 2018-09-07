function join(str, concatStr) {
  var result = '';
  for (var i=0; i<str.length; i++) {
    result += str[i] + concatStr;
  }
  console.log(result.substr(0, result.length-1));	
}

join(["a", "b", "c"], '!');

function repeat(str, times) {
  var result = '';
  for (var i=1; i<=times; i++) {
    result += str;
  }
  console.log(result);	
}

repeat('yoyo', 2);
