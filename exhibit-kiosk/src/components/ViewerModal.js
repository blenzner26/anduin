// Created by Brendan Lenzner, Raynor Memorial Libraries - Marquette University
// Modified 7/27/2022

import React, { useState, useEffect } from 'react'
import FormGroup from '@mui/material/FormGroup'
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Button from '@mui/material/Button';
import ImageViewer from './ImageViewer.js';
import LoadingScreen from './LoadingScreen.js';
import NoSelectedMessage from './NoSelectedMessage.js';
import reactStringReplace from 'react-string-replace';

const styles = ({
    modalSidebar: {
        width: '15%',
        background: '#222',
        color: '#fff',
        padding: '20px',
    },
    phrase: {
        fontSize: '1.35rem',
    },
    character: {
        fontSize: '1.2rem',
        letterSpacing: '1px',
        fontFamily: "'Trebuchet MS', sans-serif",
    },
    page: {
        fontSize: '1.1rem',
        fontFamily: "'Trebuchet MS', sans-serif",
    },
    checkboxHeader: {
        fontSize: '1.1rem',
        fontFamily: "'Trebuchet MS', sans-serif",
    },
    descriptionText: {
        fontFamily: "'Trebuchet MS', sans-serif",
        lineHeight: "1.3",
    },
    button: {
        color: '#ffffff',
        fontFamily: 'albertus_mt',
        padding: '15px',
        background: 'rgba(30, 30, 30, 0.6)',
        width: '240px',
        margin: '20px auto',
    },
});

function ViewerModal(props) {
    // create state for ImageViewer counter
    const [count, setCount] = useState(1);

    // temp array to store images from props
    let imageArray = [];

    // add image data to imageArray array from props
    props.images.forEach(element => {
        imageArray.push({ type: 'image', description: element.description, visible: true, url: "/exhibit/images/" + String(element.url), overlays: element.overlays });
    });

    // add imageArray to initial state
    const [checkState, setCheckState] = useState(imageArray);
    const [imageState, setImageState] = useState(imageArray);

    // initialize loading state to true
    const [loading, setLoading] = useState(true);

    // initialize no images selected state to false
    const [noneSelected, setNoneSelected] = useState(false);

    // handle checkbox actions
    const handleCheckbox = (description) => {
        // create temporary copy of state data for checkmark status
        let checkmarkStatus = [];
        checkState.forEach(element => {
            checkmarkStatus.push({ type: element.type, description: element.description, visible: element.visible, url: element.url, overlays: element.overlays });
        });

        // check if visiblility is set to true or false and make opposite
        if (checkmarkStatus.find(x => x.description === description).visible === true) {
            checkmarkStatus.find(x => x.description === description).visible = false;
        }
        else {
            checkmarkStatus.find(x => x.description === description).visible = true;
        }

        // create temporary image status array
        let imageStatus = [];
        checkmarkStatus.forEach(image => {
            if (image.visible === true) {
                imageStatus.push(image);
            }
        });

        // save temp image status to state
        setImageState(imageStatus);

        // save temp checkmark status to state
        setCheckState(checkmarkStatus);

        setLoading(true);

        if (imageStatus.length === 0) {
            setNoneSelected(true);
        }
        else {
            setNoneSelected(false);
        }

        if (imageStatus.length === 0) {
            setTimeout(() => {
                setLoading(false);
            }, 100);
        }
        if (imageStatus.length === 1) {
            setTimeout(() => {
                setLoading(false);
            }, 200);
        }
        else if (imageStatus.length > 1 && imageStatus.length < 5) {
            setTimeout(() => {
                setLoading(false);
            }, 500);
        }
        else if (imageStatus.length >= 5) {
            setTimeout(() => {
                setLoading(false);
            }, 900);
        }

        // change count for ImageViewer
        setCount(count + 1);
    };

    useEffect(() => {
        setTimeout(() => {
            setLoading(false);
        }, 1200);
    }, []);
    
    var passDescription = props.passageDescription;
    var bookName = "The Lord of the Rings"
    var newDescription = "";

    if (passDescription.includes(bookName)){
        passDescription = passDescription.replace(bookName, bookName);
        newDescription = <p>{passDescription}</p>;
    } 

    return (
        <div id="viewer-modal" style={{ display: 'flex' }}>
            <>
                {
                    noneSelected ? <NoSelectedMessage /> : <></>
                }
            </>
            <>
                {
                    loading ? <LoadingScreen /> : <></>
                }
            </>
            <div className="os-container" style={{ width: '85%', background: '#000000' }}>
                <ImageViewer key={props.id + "iv"} imageArray={imageState} count={count} />
            </div>
            <div className="modal-sidebar" style={styles.modalSidebar} >
                <p style={styles.phrase}>{props.phrase}</p>
                <p style={styles.character}>—{props.character}</p>
                <p style={styles.page}>(50th anniv. p. {props.page})</p>
                
                <hr />
                <p style={styles.checkboxHeader}>Select manuscripts to view:</p>
                <FormGroup>
                    {imageArray.map(({ description, image_id }) => (
                        <FormControlLabel
                            key={image_id + String(Math.random())}
                            control={<Checkbox
                                checked={checkState.find(x => x.description === description).visible}
                                onChange={() =>
                                    handleCheckbox(description)}
                                name={description.toLowerCase().replace(/\s+/g, '')} />}
                            label={description}
                        />
                    ))}
                </FormGroup>
                <hr />
                {/* italicize name of the book */}
                <p style={styles.descriptionText}>{reactStringReplace(passDescription, 'The Lord of the Rings', (match, i) => (
                    <em>The Lord of The Rings</em>
                ))}</p>
                <Button variant="outlined" className="white-outline" style={styles.button} onClick={props.handleClose}>&larr; Back to all Passages</Button>
            </div>
        </div>
    );
}

export default ViewerModal;