import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Link } from 'react-router-dom'

import About from 'components/about.jsx';
import Friends from 'components/friends.jsx';
import Home from 'components/home.jsx';


export default class App extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return(
            <BrowserRouter>
                <div>
                    <ul>
                        <li><Link to='/'>Home</Link></li>
                        <li><Link to='/about'>About</Link></li>
                        <li><Link to='/friends'>Friends</Link></li>
                    </ul>

                    <Route exact path='/' component={Home}/>
                    <Route path='/about' component={About}/>
                    <Route path='/friends' component={Friends}/>
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(
    <App />,
    document.getElementById('app')
);
