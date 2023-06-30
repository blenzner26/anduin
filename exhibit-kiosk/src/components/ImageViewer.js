// Created by Brendan Lenzner, Raynor Memorial Libraries - Marquette University
// Modified 7/27/2022

import React, { useEffect, useState } from "react";
import OpenSeaDragon from "openseadragon";
import zoomin_grouphover from '../images/openseadragon/zoomin_grouphover.png';
import zoomin_hover from '../images/openseadragon/zoomin_hover.png';
import zoomin_pressed from '../images/openseadragon/zoomin_pressed.png';
import zoomin_rest from '../images/openseadragon/zoomin_rest.png';
import zoomout_grouphover from '../images/openseadragon/zoomout_grouphover.png';
import zoomout_hover from '../images/openseadragon/zoomout_hover.png';
import zoomout_pressed from '../images/openseadragon/zoomout_pressed.png';
import zoomout_rest from '../images/openseadragon/zoomout_rest.png';
import fullpage_grouphover from '../images/openseadragon/fullpage_grouphover.png';
import fullpage_hover from '../images/openseadragon/fullpage_hover.png';
import fullpage_pressed from '../images/openseadragon/fullpage_pressed.png';
import fullpage_rest from '../images/openseadragon/fullpage_rest.png';
import home_grouphover from '../images/openseadragon/home_grouphover.png';
import home_hover from '../images/openseadragon/home_hover.png';
import home_pressed from '../images/openseadragon/home_pressed.png';
import home_rest from '../images/openseadragon/home_rest.png';
import next_grouphover from '../images/openseadragon/next_grouphover.png';
import next_hover from '../images/openseadragon/next_hover.png';
import next_pressed from '../images/openseadragon/next_pressed.png';
import next_rest from '../images/openseadragon/next_rest.png';
import previous_grouphover from '../images/openseadragon/previous_grouphover.png';
import previous_hover from '../images/openseadragon/previous_hover.png';
import previous_pressed from '../images/openseadragon/previous_pressed.png';
import previous_rest from '../images/openseadragon/previous_rest.png';
import rotateleft_grouphover from '../images/openseadragon/rotateleft_grouphover.png';
import rotateleft_hover from '../images/openseadragon/rotateleft_hover.png';
import rotateleft_pressed from '../images/openseadragon/rotateleft_pressed.png';
import rotateleft_rest from '../images/openseadragon/rotateleft_rest.png';
import rotateright_grouphover from '../images/openseadragon/rotateright_grouphover.png';
import rotateright_hover from '../images/openseadragon/rotateright_hover.png';
import rotateright_pressed from '../images/openseadragon/rotateright_pressed.png';
import rotateright_rest from '../images/openseadragon/rotateright_rest.png';

const styles = ({
  osViewer: {
    height: "calc(100vh - 80px)",
  },
  toolbar: {
    position: "absolute",
    zIndex: "900",
    marginLeft: "10px",
    marginTop: "10px",
  },
});

const ImageViewer = (props) => {
  const [viewer, setViewer] = useState(null);
  var numberOfRows = 2;
  var imageArray = props.imageArray;

  // adjust number of rows based on length of imageArray (the number of images)
  if (imageArray.length <= 4) {
    numberOfRows = 1;
  }
  else if (imageArray.length > 4 && imageArray.length <= 8) {
    numberOfRows = 2;
  }
  else if (imageArray.length > 8 && imageArray.length <= 12) {
    numberOfRows = 3;
  }
  else if (imageArray.length > 12) {
    numberOfRows = 4;
  }

  useEffect(() => {
    if (imageArray && viewer) {
      viewer.open(imageArray);
    }
  }, [props.count]);

  const InitOpenseadragon = () => {
    viewer && viewer.destroy();
    setViewer(
      OpenSeaDragon({
        id: "openseadragon",
        prefixUrl: "",
        navImages: {
          zoomIn: {
            REST: zoomin_rest,
            GROUP: zoomin_grouphover,
            HOVER: zoomin_hover,
            DOWN: zoomin_pressed,
          },
          zoomOut: {
            REST: zoomout_rest,
            GROUP: zoomout_grouphover,
            HOVER: zoomout_hover,
            DOWN: zoomout_pressed,
          },
          home: {
            REST: home_rest,
            GROUP: home_grouphover,
            HOVER: home_hover,
            DOWN: home_pressed,
          },
          fullpage: {
            REST: fullpage_rest,
            GROUP: fullpage_grouphover,
            HOVER: fullpage_hover,
            DOWN: fullpage_pressed,
          },
          previous: {
            REST: previous_rest,
            GROUP: previous_grouphover,
            HOVER: previous_hover,
            DOWN: previous_pressed,
          },
          next: {
            REST: next_rest,
            GROUP: next_grouphover,
            HOVER: next_hover,
            DOWN: next_pressed,
          },
          rotateleft: {
            REST: rotateleft_rest,
            GROUP: rotateleft_grouphover,
            HOVER: rotateleft_hover,
            DOWN: rotateleft_pressed,
          },
          rotateright: {
            REST: rotateright_rest,
            GROUP: rotateright_grouphover,
            HOVER: rotateright_hover,
            DOWN: rotateright_pressed,
          },
        },
        tileSources: imageArray,
        toolbar: 'toolbar',
        collectionMode: true,
        collectionRows: numberOfRows,
        collectionTileSize: 1024,
        collectionTileMargin: 0,
        showRotationControl: true,
        // Disable touch rotation
        gestureSettingsTouch: {
          pinchRotate: false
        },
        showNavigator: false,
      }),
    );
  };

  useEffect(() => {
    InitOpenseadragon();
    return () => {
      viewer && viewer.destroy();
      setViewer(null);
    };
  }, [props.count]);

  return (
    <div className="openseadragon-wrapper">
      <div id="toolbar" style={styles.toolbar}></div>
      <div id="openseadragon" style={styles.osViewer}></div>
    </div >
  );
};
export default ImageViewer;