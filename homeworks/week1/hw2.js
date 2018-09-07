function capitalize (str) {
  var result = '';   
  if (str[0]>='a' && str[0]<='z') {
     result += str[0].toUpperCase() + str.substr(1);  
  } else {   	
     console.log(str);   
  }   
    return result; 
}

console.log(capitalize('nick'));
console.log(capitalize(',hello'));
console.log(capitalize('Nick'));
