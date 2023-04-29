import React from 'react';

export default function Label({ forInput, value, className, children }) {
    return (
        <label htmlFor={forInput} className={`form-label fs-6 fw-bolder text-dark` + className}>
            {value ? value : children}
        </label>
    );
}
