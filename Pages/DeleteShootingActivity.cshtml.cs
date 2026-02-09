using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteShootingActivityModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteShootingActivityModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var activity = await _context.ShootingActivities.FindAsync(id);

        if (activity != null)
        {
            activity.Status = "I";
            await _context.SaveChangesAsync();
        }

        return Redirect(Request.Headers["Referer"].ToString() ?? "/Index");
    }
}
