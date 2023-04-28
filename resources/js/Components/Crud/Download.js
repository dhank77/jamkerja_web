import React from 'react'

export default function Download({ file }) {
  return (
    <>
        {
            file != "" && file != null ?
            <a href={file} target="_blank" className='badge badge-primary'>Unduh</a>
            :
            <span className='badge badge-dark'>Tidak Ada Berkas</span>
        }
    </>
  )
}
