import React, { Component } from 'react'
import $ from 'jquery'

export default class Home extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        $.ajax({
            url: "http://localhost:8080/",
            dataType: 'json',
            cache: false,
            success: (data) => {
                console.log(data);
            },
            error: (xhr, status, err) => {
                console.log(status);
            }
        });
    }

    render() {
        return (
            <div>
                <h2>Home</h2>
                <p>Welcome to ようこそ</p>
            </div>
        );
    }
}
