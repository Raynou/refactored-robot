/**
 * Saves the image and ...
 * @param {video} video - The camera feedback
 * @param {canvas} canvas - The canvas where the image will be temporally saved
 * @returns Nothing
 */
function save_image(video, canvas) {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    // let image_data_url = canvas.toDataURL('image/jpeg');
    // window.alert(image_data_url);
}

export const init = (timer) => {
    let video = document.querySelector("#camera");
    let canvas = document.querySelector("#canvas");
    let save_button = document.querySelector("#save_button");

    navigator.mediaDevices.getUserMedia({ video: true, audio: false }).then((stream) => {
        video.srcObject = stream;
        video.play();
    }).catch((error) => window.alert(error));

    save_button.addEventListener('click', function() {
        save_image(video, canvas);
    });

    setInterval(save_image, timer, video, canvas);
    // window.alert("The init function was called");
    // video.srcObject = stream;
    // canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    // let image_data_url = canvas.toDataURL('image/jpeg');
};
