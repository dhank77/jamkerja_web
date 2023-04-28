import React from 'react'

export default function File({ file }) {
    return (
        file != "" ?
            <a href={file} target="_blank" className='badge badge-success'>Download</a>
            :
            <a href="#" className='badge badge-dark'>Tidak Ada File</a>
    )
}
