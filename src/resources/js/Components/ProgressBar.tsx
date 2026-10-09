import { CircularProgressbar, buildStyles } from 'react-circular-progressbar'
import "react-circular-progressbar/dist/styles.css"

export default function ProgressBar() {
    const percentageUsed = 50

    return (
        <CircularProgressbar
        value={percentageUsed}
        styles={buildStyles({
            pathColor: '#3C0366',
            trailColor: '#F5F5F5',
            textSize: 8,
            textColor: '#F59E0B' // amber-500
        })}
        text={`${percentageUsed}% Gastado`}
        />
    )
}
