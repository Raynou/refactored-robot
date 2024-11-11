/**
 * Saves the image
 * @param {video} video - The camera feedback
 * @param {canvas} canvas - The canvas where the image will be temporally saved
 * @param {string} title The title of the page where the photo is taken
 * @param {number} userId The id of the user
 */
const saveImage = (video, canvas, title, userId) => {
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
    const date = new Date();
    const formatMinutes = (minutes) => {
        const stringMinutes = minutes.toString();
        if (stringMinutes.length === 1) {
            return "0" + stringMinutes;
        }
        return stringMinutes;
    };

    const time = `${date.getHours()}:${formatMinutes(date.getMinutes())}`;
    const body = {
        photo: canvas.toDataURL(),
        page: title,
        userId: userId,
        time: time,
    };

    fetch("/moodle/blocks/simplecamera/api.php", {
        method: "POST",
        mode: "no-cors",
        headers: {
            "Content-type": "application/json",
        },
        body: JSON.stringify(body),
    });
};

/**
 * Get the current time value from local storage
 * @returns {number} A number that represents time.
 */
const getFromLocalStorage = () => {
    return parseInt(localStorage.getItem("timeTranscurred"));
};

/**
 * Put a value of the local storage.
 * @param {number} seconds A number which represents the time transcurred in the timer
 */
const pushToLocalStorage = (seconds) => {
    localStorage.setItem("timeTranscurred", seconds.toString());
};

export const init = (timer, title, id) => {
    let video = document.querySelector("#camera");
    let canvas = document.querySelector("#canvas");
    let saveButton = document.querySelector("#save_button");
    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
        .then((stream) => {
            video.srcObject = stream;
            video.play();
        })
        .catch((error) => window.alert(error));

    saveButton.addEventListener("click", () => {
        // Hey! I don't do anything :D!
    });

    if (getFromLocalStorage() === null || isNaN(getFromLocalStorage())) {
        pushToLocalStorage(0);
    }

    setInterval(() => {
        if (getFromLocalStorage() === timer / 1000) {
            saveImage(video, canvas, title, id);
            pushToLocalStorage(0);
        } else {
            pushToLocalStorage(getFromLocalStorage() + 1);
        }
    }, 1000);
};
