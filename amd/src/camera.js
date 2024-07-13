/**
 * Saves the image and ...
 * @param {video} video - The camera feedback
 * @param {canvas} canvas - The canvas where the image will be temporally saved
 * @param {string} title The title of the page where the photo is taken
 * @param {number} userId The id of the user
 * @param {string} url The API's URL
 * @returns Nothing
 */
function save_image(video, canvas, title, userId, url) {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    const date = new Date();

    const formatMinutes = (minutes) => {
        const stringMinutes = minutes.toString();
        if(stringMinutes.length == 1) {
            return "0" + stringMinutes;
        }
        return stringMinutes;
    };

    const time = `${date.getHours()}:${formatMinutes(date.getMinutes())}`;
    const mockBody = {
        photo: canvas.toDataURL(),
        page:  title,
        userId: userId,
        time: time
    };

    console.log(mockBody);

    fetch(url, {
        method: "POST",
        mode: "no-cors",
        headers: {
            "Content-type":"application/json"
        },
        body: JSON.stringify(mockBody)
    });
}

/**
 * Get the current time value from local storage
 * @returns {number} A number that represents time.
 */
function getFromLocalStorage() {
    return parseInt(localStorage.getItem("timeTranscurred"));
}

/**
 * Put a value of the local storage.
 * @param {number} seconds A number which represents the time transcurred in the timer
 */
function pushToLocalStorage(seconds) {
    localStorage.setItem("timeTranscurred", seconds.toString());
}

export const init = (timer, title, id, url) => {
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

    if(getFromLocalStorage() === null || isNaN(getFromLocalStorage())) {
        pushToLocalStorage(0);
    }
    setInterval(() => {
        if(getFromLocalStorage()  === timer/1000) {
            save_image(video, canvas, title, id, url);
            pushToLocalStorage(0);
        }else {
            const aux = getFromLocalStorage();
            pushToLocalStorage(aux+1);
        }
    }, 1000);
};
