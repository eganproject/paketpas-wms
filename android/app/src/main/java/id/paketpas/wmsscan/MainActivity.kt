package id.paketpas.wmsscan

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import androidx.navigation.navArgument
import id.paketpas.wmsscan.data.Session
import id.paketpas.wmsscan.data.Stages
import id.paketpas.wmsscan.ui.AbsenHistoryScreen
import id.paketpas.wmsscan.ui.AbsenScreen
import id.paketpas.wmsscan.ui.HomeScreen
import id.paketpas.wmsscan.ui.KemasScreen
import id.paketpas.wmsscan.ui.LoginScreen
import id.paketpas.wmsscan.ui.OrderDetailScreen
import id.paketpas.wmsscan.ui.OrdersScreen
import id.paketpas.wmsscan.ui.ReturScreen
import id.paketpas.wmsscan.ui.SerahTerimaScreen
import id.paketpas.wmsscan.ui.UpdatePrompt
import id.paketpas.wmsscan.ui.components.Tab
import id.paketpas.wmsscan.ui.theme.WmsTheme

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        enableEdgeToEdge()
        super.onCreate(savedInstanceState)
        setContent {
            WmsTheme {
                AppRoot()
                UpdatePrompt()
            }
        }
    }
}

@Composable
private fun AppRoot() {
    val user by Session.user.collectAsStateWithLifecycle()

    if (user == null) {
        LoginScreen()
        return
    }

    val nav = rememberNavController()
    val openTab: (Tab) -> Unit = { tab -> nav.openTab(tab) }

    NavHost(navController = nav, startDestination = "home") {
        composable("home") {
            HomeScreen(
                user = user!!,
                onTab = openTab,
                onAbsen = { type -> nav.navigate("absen/$type") { launchSingleTop = true } },
                onAbsenHistory = { nav.navigate("absen-riwayat") { launchSingleTop = true } },
                onRetur = { if (user?.can?.retur == true) nav.navigate("retur") { launchSingleTop = true } },
            )
        }
        composable(
            "absen/{type}",
            arguments = listOf(navArgument("type") { type = NavType.StringType }),
        ) { entry ->
            AbsenScreen(
                type = entry.arguments?.getString("type") ?: "in",
                onBack = { nav.popBackStack() },
                onDone = { nav.popBackStack("home", inclusive = false) },
            )
        }
        composable("absen-riwayat") { AbsenHistoryScreen(onBack = { nav.popBackStack() }) }
        composable("kemas") { KemasScreen(onBack = { nav.popBackStack() }) }
        composable("retur") { ReturScreen(onBack = { nav.popBackStack() }) }
        composable("serah") {
            SerahTerimaScreen(
                onBack = { nav.popBackStack() },
                onQueue = { nav.navigate("orders/${Stages.SUDAH}") },
            )
        }
        composable(
            "orders/{stage}",
            arguments = listOf(navArgument("stage") { type = NavType.StringType }),
        ) { entry ->
            OrdersScreen(
                initialStage = entry.arguments?.getString("stage") ?: Stages.BELUM,
                onTab = openTab,
                onOpen = { id -> nav.navigate("order/$id") },
            )
        }
        composable(
            "order/{id}",
            arguments = listOf(navArgument("id") { type = NavType.IntType }),
        ) { entry ->
            OrderDetailScreen(
                id = entry.arguments?.getInt("id") ?: 0,
                onBack = { nav.popBackStack() },
            )
        }
    }
}

private fun NavHostController.openTab(tab: Tab) {
    val user = Session.user.value ?: return
    when (tab) {
        Tab.Home -> popBackStack("home", inclusive = false)
        Tab.Kemas -> if (user.can.kemas) navigate("kemas")
        Tab.Serah -> if (user.can.serahTerima) navigate("serah")
        Tab.Pesanan -> if (user.can.pesanan) navigate("orders/${Stages.BELUM}") {
            popUpTo("home")
            launchSingleTop = true
        }
    }
}
