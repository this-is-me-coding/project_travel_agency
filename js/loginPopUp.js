const accButton = document.querySelector('.user_icon');
const accButtonClose = document.querySelector('.login_popup_close');
const accPopUp = document.querySelector('.popup_user_login_or_options');
const signUp = document.querySelector('.signup');
const logOut = document.querySelector('#explore_data_logout_button');

[accButton, accButtonClose].forEach(item => {
    item.addEventListener('click', () => {
        accPopUp.classList.toggle("shown");
    })
  });

signUp.addEventListener('click', () => {
    window.location.replace("signup.php")
});