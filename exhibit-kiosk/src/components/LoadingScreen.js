// Created by Brendan Lenzner, Raynor Memorial Libraries - Marquette University
// Modified 7/27/2022

import React from 'react'
import CircularProgress from '@mui/material/CircularProgress';

const styles = ({
    loadingBackground: {
        background: "#00000088",
        display: "flex",
        justifyContent: "center",
        height: "calc(100vh - 80px)",
        width: "calc(85% - 35px)",
        zIndex: 1000,
        position: "absolute",
    },
    loadingIndicator: {
        marginTop: "29%"
    }
});

function LoadingScreen(props) {
    return (
        <div style={styles.loadingBackground}>
            <CircularProgress style={styles.loadingIndicator} disableShrink />
        </div>
    );
}

export default LoadingScreen;