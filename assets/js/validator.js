//đối tượng validator
function Validator(options) {
    var selectorRules = {};

    function validate(inputElement, rule) {
        var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
        var errorMessage;

        var rules = selectorRules[rule.selector];

        //lặp qua từng rule và kiểm tra
        //nếu có lỗi thì dừng kiểm tra
        for (var i = 0; i < rules.length; i++) {
            errorMessage = rules[i](inputElement.value);
            if (errorMessage) break;
        }

        if (errorMessage) {
            errorElement.innerText = errorMessage;
            inputElement.parentElement.classList.add("invalid");
        } else {
            errorElement.innerText = "";
            inputElement.parentElement.classList.remove("invalid");
        }

        return !errorMessage;
    }

    //lấy element của form cần validate
    var formElement = document.querySelector(options.form);
    if (formElement) {
        //bỏ qua hành vi mặc định của form
        formElement.onsubmit = function (e) {
            e.preventDefault();

            var isFormValid = true;
            //lặp qua từng rule và thực hiẹn validate
            options.rules.forEach(function (rule) {
                var inputElement = formElement.querySelector(rule.selector);
                var isValid = validate(inputElement, rule);
                if (!isValid) {
                    isFormValid = false;
                }
            });

            if (isFormValid) {
                //trường hợp submit với Javascript
                if (typeof options.onSubmit === "function") {
                    var enableInputs = formElement.querySelectorAll("[name]:not([disable])");
                    var formValues = Array.from(enableInputs).reduce(function (values, input) {
                        values[input.name] = input.value;
                        return values;
                    }, {});
                    options.onSubmit(formValues);
                }
            }
            //trưỜng hợp submit với hành vi mặc định
            else {
                formElement.submit();
            }
        };

        //lặp qua mỗi rule và xử lý (lắng nghe sự kiện: VD blur, oninput)
        options.rules.forEach(function (rule) {
            //lưu lại các rule cho mỗi input

            if (Array.isArray(selectorRules[rule.selector])) {
                selectorRules[rule.selector].push(rule.test);
            } else {
                selectorRules[rule.selector] = [rule.test];
            }

            var inputElement = formElement.querySelector(rule.selector);

            if (inputElement) {
                //xử lý trường hơp blur khỏi input
                inputElement.onblur = function () {
                    validate(inputElement, rule);
                };

                //xử lý mỗi khi người dùng nhập vào input
                inputElement.oninput = function () {
                    var errorElement = inputElement.parentElement.querySelector(".form-message");

                    errorElement.innerText = "";
                    inputElement.parentElement.classList.remove("invalid");
                };
            }
        });
    }
}

//định nghĩa rule phải nhập trường name
Validator.isRequired = function (selector) {
    return {
        selector: selector,
        test: function (value) {
            return value.trim() ? undefined : "Vui lòng nhập trường này";
        },
    };
};

//định nghĩa rule phải là email
Validator.isEmail = function (selector) {
    return {
        selector: selector,
        test: function (value) {
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(value) ? undefined : "Trường này phải là email";
        },
    };
};

//dộ dài tối thiểu của password
Validator.minLength = function (selector, min) {
    return {
        selector: selector,
        test: function (value) {
            return value.length >= min ? undefined : `Vui lòng nhập tối thiểu ${min} ký tự`;
        },
    };
};

// xac nhan mat khau
Validator.isConfirmed = function (selector, getConfirmValue, message) {
    return {
        selector: selector,
        test: function (value) {
            return value === getConfirmValue() ? undefined : message || "Giá trị nhập vào không chính xác";
        },
    };
};
