import React, { Component } from 'react'

export default class Friends extends Component {
    constructor(props) {
        super(props);
    }

    setTitle() {
        document.title = 'Friends';
    }

    componentDidMount() {
        this.setTitle();
    }

    render() {
        return(
            <div>
                <h2>Friends</h2>
                <p>ここにフレンズのリストを書きます</p>
            </div>
        );
    }
}
