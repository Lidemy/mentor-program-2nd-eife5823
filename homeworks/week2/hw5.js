function add(a, b) {
  a = a.split('').reverse(); // a= ["4", "3", "2", "1"]
  b = b.split('').reverse(); // b = ["9", "8", "7", "6", "5"]

  var result = [];
  var length = Math.max(a.length, b.length); // length = 5
  var carry = 0;
  for (var  i = 0; i < length; i++) {
    var sum = parseInt(a[i] || 0 ) + parseInt(b[i] || 0 ) + carry; // sum = 每個元素總和+進位
    result[i] = sum % 10; // 新陣列的每個元素為(元素總和+進位)除以10的餘數
    carry = (sum - result[i]) / 10; // 進位=(元素總和-餘數) /10
  }

  if (carry) {
    result.push(carry); // 若最後有進位要再push進位到新陣列
  }

  return result.reverse().join('');
}
  

module.exports = add;