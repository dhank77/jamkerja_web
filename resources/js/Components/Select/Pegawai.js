import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Pegawai({ onchangeHandle, valueHandle, isMulti='true' }) {

  const [data, setData] = useState([])

   useEffect(() => {
      loadpegawai();
   }, [])

   const loadpegawai = async () => {
    try {
      let { data } = await axios.get(route('pegawai.pegawai.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
   }


  return (
    <Select options={data} isMulti={isMulti} onChange={onchangeHandle} defaultValue={valueHandle} />
  )
}
