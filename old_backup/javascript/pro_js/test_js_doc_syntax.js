/**
 * 수학 계산 유틸리티.
 * @namespace MYAPP
 * @class math_stuff
 */
MYAPP.math_stuff = {
	/**
	 * 수학 계산 유틸리티.
	 * @method sum
	 * @param {Number} a 첫 번째 숫자
	 * @param {Number} b 두 번째 숫자
	 * @return {Number} 두 숫자를 더한 값
	 */		
	sum:function(a,b) {
		return a + b;
	}
	/**
	 * 수학 계산 유틸리티.
	 * @method sum
	 * @param {Number} a 첫 번째 숫자
	 * @param {Number} b 두 번째 숫자
	 * @return {Number} 두 숫자를 더한 값
	 */		
	multi:function (a,b) {
		return a * b;
	}
};

/**
 * Person 객체를 생성한다.
 * @class Person
 * @constructor
 * @namespace MYapp
 * @param {String} first 이름
 * @param {String} last 성
 */
MYAPP.Person = function(first, last){
	/**
	 * 사람의 이름
	 * @property first_name
	 * @type String
	 */
	this.first_name = first;
	/**
	 * @property last_name
	 * @type String
	 */
	this.last_name = last;
	
	/**
	 * person 객체의 성명을 반환한다.
	 * @method getName
	 * @return {String} 사람의 성명
	 */
	MYAPP.Person.prototype.getName = function() {
		return this.first_name + ' ' + this.last_name;
	};
};
