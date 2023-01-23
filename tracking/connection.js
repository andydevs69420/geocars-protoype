import {initializeApp} from "https://www.gstatic.com/firebasejs/9.6.2/firebase-app.js";
import {doc,setDoc,getFirestore,onSnapshot} from "https://www.gstatic.com/firebasejs/9.6.2/firebase-firestore.js";

const firebaseConfig = {
    apiKey: "AIzaSyDOk5ITVxhiW4yYJok7jnzsfWnXWuxwh-Y",
    authDomain: "geocars2021.firebaseapp.com",
    projectId: "geocars2021",
    storageBucket: "geocars2021.appspot.com",
    messagingSenderId: "67620653500",
    appId: "1:67620653500:web:7e35fec38cd355276fc3b9",
    measurementId: "G-9YC2H8ZXLT"
};

export var APP;
export var DB;

try {
    APP = initializeApp(firebaseConfig);
    DB  = getFirestore();
}catch(err) {
    console.log(err);
}

export const getLocationData = async (docstring,onUpdate) => {
    let docpath = doc(DB,"cars",docstring); 
    onSnapshot(docpath,(document) => onUpdate(document));
}

export const transmitInBackground = (docstring,lat,lng) => {
    let docpath = doc(DB,"cars",docstring); 
    setDoc(docpath, { currentLoc:{lat: lat , lng: lng , process:"BACKGROUND"} }, { merge: true });
};

export const sendMessage = (docstring,msg) => {
    let docpath = doc(DB,"messages",docstring); 
    setDoc(docpath, { message: msg }, { merge: true });
};


