using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteMaintenanceModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteMaintenanceModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var maintenance = await _context.Maintenance.FindAsync(id);

        if (maintenance != null)
        {
            maintenance.Status = "I";
            await _context.SaveChangesAsync();
        }

        return Redirect(Request.Headers["Referer"].ToString() ?? "/Index");
    }
}
