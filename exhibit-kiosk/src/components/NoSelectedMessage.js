// Created by Brendan Lenzner, Raynor Memorial Libraries - Marquette University
// Modified 7/27/2022

import React from 'react'

const styles = ({
    background: {
        background: "#00000088",
        display: "flex",
        justifyContent: "center",
        height: "calc(100vh - 80px)",
        width: "calc(85% - 35px)",
        zIndex: 1000,
        position: "absolute",
    },
    message: {
        color: "#ffffff",
        fontWeight: "bold",
        fontSize: "1.5rem",
        marginTop: "29%",
    }
});

function NoSelectedMessage(props) {
    return (
        <div style={styles.background} className="message">
            <p style={styles.message}>No images are selected. Please select an image on the right to get started.</p>
        </div>
    );
}

export default NoSelectedMessage;