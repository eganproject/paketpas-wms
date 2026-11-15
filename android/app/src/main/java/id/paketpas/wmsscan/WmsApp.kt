package id.paketpas.wmsscan

import android.app.Application
import id.paketpas.wmsscan.data.Session
import id.paketpas.wmsscan.data.Updater

class WmsApp : Application() {
    override fun onCreate() {
        super.onCreate()
        Session.init(this)
        Updater.init(this)
    }
}
