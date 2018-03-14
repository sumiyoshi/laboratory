import React, { Component } from 'react'

export default class About extends React.Component {
    constructor(props) {
        super(props);
    }

    setTitle() {
        document.title = 'About';
    }
    
    componentDidMount() {
        this.setTitle();
    }

    render() {
        return(
            <div>
                <h2>About</h2>
                <p>フレンズに投票するページです</p>
            </div>
        );
    }
}

