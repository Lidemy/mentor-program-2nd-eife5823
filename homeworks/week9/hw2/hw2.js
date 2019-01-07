function Stack () {
	let arr = [];
	let i = 0;
	return {
		push: function(n) {
			arr[i] = n; // 第一個放進去的數字
			i++;
		},

		pop: function() {
			let result = arr[i-1]; // 要 pop 掉的數字
			arr.splice(i-1, 1); // 利用 splice 把數字移除
			i--; // 移除數字後的 array length
			return result;	// return pop 掉的數字
		}
	}
}

var stack = new Stack();
stack.push(10)
stack.push(5)
console.log(stack.pop()) 
console.log(stack.pop()) 

function Queue () {
	let arr = [];
	let i = 0;
	return {
		push: function(n) {
			arr[i] = n; // 第一個放進去的數字
			i++;
		},

		pop: function() {
			let result = arr[0]; // first in first out 結果永遠會是 arr[0]
			arr.splce(0,1); // 永遠把 arr[0] 移除
			i--;
			return result;
		}
	};
}

var queue = new Queue()
queue.push(1)
queue.push(2)
console.log(queue.pop()) 
console.log(queue.pop()) 