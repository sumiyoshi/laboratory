import React, { Component } from 'react'
import { Link } from 'react-router-dom'

export default class Nav extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <nav>
                <ul>
                    <li><Link to='/'>Home</Link></li>
                    <li><Link to='/about'>About</Link></li>
                    <li><Link to='/friends'>Friends</Link></li>
                </ul>
            </nav>
        );
    }
}

