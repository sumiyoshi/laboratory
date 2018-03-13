import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route } from 'react-router-dom'

import About from 'components/pages/about.jsx';
import Friends from 'components/pages/friends.jsx';
import Home from 'components/pages/home.jsx';

import Footer from 'components/footer.jsx';
import Header from 'components/header.jsx';
import Nav from 'components/nav.jsx';

export default class App extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <BrowserRouter>
                <div>
                    <Header />
                    <Nav />
                    <div id="content">
                        <Route exact path='/' component={Home}/>
                        <Route path='/about' component={About}/>
                        <Route path='/friends' component={Friends}/>
                    </div>
                    <Footer />
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(
    <App />,
    document.getElementById('app')
);
