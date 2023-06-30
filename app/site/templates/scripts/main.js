var imageSource;

const setImage = (imageURL) => {
    imageSource = imageURL;
};

const openImageModal = () => {
    var manContainer = document.getElementById("manuscript-container");
    var manuscript = document.createElement("div");
    var toolbar = document.createElement("div");

    manuscript.id = "manuscript";
    toolbar.id = "toolbar";

    manContainer.appendChild(manuscript);
    manuscript.appendChild(toolbar);

    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
        keyboard: true
    });

    // Displays modal containing full image
    imageModal.show();
    $("#imageModal").appendTo("body");

    closeModal = () => {
        imageModal.hide();
    };

    var sourceJSON = {
        type: 'image',
        url: imageSource,
    };

    OpenSeadragon({
        id: "manuscript",
        prefixUrl: "/site/templates/scripts/openseadragon/images/",
        tileSources: sourceJSON,
        toolbar: "toolbar",
        showRotationControl: true,
        rotationIncrement: 45,
        // Disable touch rotation on tactile devices
    });

    var currentModal = document.getElementById('imageModal');

    currentModal.addEventListener('hidden.bs.modal', () => {
        document.getElementById("manuscript").remove();
    });
};