export default function (key) {
    let trans = key;

    try {
        const t =  __trans[key];
        if (typeof t === 'string') {
            trans = t;
        }
    } catch (err) {
        console.log(err.message);
    }
    ;

    return trans;
}
