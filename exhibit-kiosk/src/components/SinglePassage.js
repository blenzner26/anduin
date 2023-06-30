// Created by Brendan Lenzner, Raynor Memorial Libraries
// Modified 7/27/2022

import React from 'react';
import Card from '@material-ui/core/Card';
import Button from '@material-ui/core/Button';
import Modal from '@material-ui/core/Modal';
import Fade from '@material-ui/core/Fade';
import ViewerModal from './ViewerModal';

const styles = ({
    phrase: {
        fontSize: '1.7rem',
        marginBottom: '10px',
    },
    character: {
        fontSize: '1.4rem',
        fontWeight: 'bold',
        margin: 0,
    },
    page: {
        fontSize: '1.4rem',
    },
    card: {
        padding: '10px',
        width: '22%',
        textAlign: 'center',
        marginTop: '20px',
        marginBottom: '20px',
        background: 'transparent',
        color: '#ffffff',
        border: "none",
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'center',
    },
    modal: {
        backgroundColor: '#222',
        width: '95%',
        margin: '40px auto',
        overflow: 'auto',
    },
    button: {
        color: '#ffffff',
        fontFamily: 'albertus_mt',
        padding: '15px 25px',
        background: 'rgba(30, 30, 30, 0.6)',
        width: '200px',
        margin: '0 auto',
    }
});

function SinglePassage(props) {
    const [open, setFadeOpen] = React.useState(false);

    const handleOpen = () => {
        setFadeOpen(true);
    };
    const handleClose = () => {
        setFadeOpen(false);
    };

    // Change "Page" label to plural if more than one page number
    var pageLabel = "Page ";

    if (props.page.includes(",") || props.page.includes("&")) {
        pageLabel = "Pages ";
    }

    return (
        <Card variant="outlined" style={styles.card}>
            <p className="phrase" style={styles.phrase}>{props.phrase}</p>
            <p className="character" style={styles.character}>—{props.character}</p>
            <p className="page" style={styles.page}>{pageLabel}{props.page}</p>
            <Button variant="outlined" className="white-outline" style={styles.button} onClick={handleOpen}>View Manuscripts</Button>
            <Modal
                open={open}
                onClose={handleClose}
                aria-labelledby="image-viewer"
                aria-describedby="manuscript viewer"
                style={styles.modal}
                className="manuscript-modal"
            >
                <Fade in={open} timeout={{ enter: 800, exit: 100 }}>
                    <div>
                        <ViewerModal key={props.id + "vm"} id={props.id} phrase={props.phrase} character={props.character} page={props.page} images={props.images} passageDescription={props.passageDescription} handleClose={handleClose} />
                    </div>
                </Fade>
            </Modal>
        </Card>
    );
}

export default SinglePassage;