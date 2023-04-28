import React, { Component } from 'react';
import OrgChart from '@balkangraph/orgchart.js';

export default class extends Component {

    constructor(props) {
        super(props);
        this.divRef = React.createRef();
        this.state = {
            nodeData: this.props.nodes,
        };
    }

    shouldComponentUpdate() {
        return false;
    }

    componentWillReceiveProps = (nextProps) => {
        if (nextProps.nodes !== this.props.nodes) {
            this.setState({...this.state, nodeData : nextProps.nodes });
            this.chart = new OrgChart(this.divRef.current, {
                nodes: nextProps.nodes,
                template: 'mila',
                mouseScrool: OrgChart.none,
                scaleInitial: OrgChart.match.boundary,
                editForm: {
                    buttons: false,
                },
                nodeBinding: {
                    field_0: "name",
                    img_0: "img",
                    field_1: "title"
                }
            });
        }
    }


    componentDidMount() {
        this.chart = new OrgChart(this.divRef.current, {
            nodes: this.state.nodeData,
            template: 'mila',
            mouseScrool: OrgChart.none,
            scaleInitial: OrgChart.match.boundary,
            editForm: {
                buttons: false,
            },
            nodeBinding: {
                field_0: "name",
                img_0: "img",
                field_1: "title"
            }
        });
    }

    render() {
        return (
            <div id="tree" ref={this.divRef}></div>
        );
    }
}
