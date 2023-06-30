// Created by Brendan Lenzner, Raynor Memorial Libraries - Marquette University
// Modified 7/27/2022

import React from "react";
import SinglePassage from "./SinglePassage.js";
import Fade from '@material-ui/core/Fade';

const styles = ({
    passages: {
        display: "flex",
        flexWrap: "wrap",
        justifyContent: "space-around",
    },
})

function Passages() {
    const [open, setFadeOpen] = React.useState(true);

    // Load data from data.json file located in root of folder
    const passagesData = require("../data.json");

    // Load data from JSON into an array
    const passageArray = passagesData.passages;

    return (
        <Fade in={open} timeout={{ enter: 800, exit: 100 }}>
            <div className="passages" style={styles.passages}>
                {passageArray.map(({ id, phrase, character, page, images, description }) => (
                    <SinglePassage key={id} phrase={phrase} character={character} page={page} images={images} passageDescription={description} id={id} />
                ))}
            </div>
        </Fade>
    );
}

export default Passages;